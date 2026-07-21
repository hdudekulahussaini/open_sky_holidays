<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCardResource;
use App\Http\Resources\BlogDetailResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{

    public function index(
        Request $request
    ): AnonymousResourceCollection {
        $perPage = $request->integer('per_page', 6);

        $perPage = max(1, min($perPage, 24));

        $blogs = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()

            ->when(
                $request->filled('category'),
                function ($query) use ($request) {
                    $categorySlug = trim(
                        $request->input('category')
                    );

                    $query->whereHas(
                        'category',
                        function ($categoryQuery) use (
                            $categorySlug
                        ) {
                            $categoryQuery->where(
                                'slug',
                                $categorySlug
                            );
                        }
                    );
                }
            )

            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = trim(
                        $request->input('search')
                    );

                    $query->where(
                        function ($searchQuery) use ($search) {
                            $searchQuery
                                ->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'content',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )

            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();

        return BlogCardResource::collection($blogs);
    }


    public function show(
        Request $request,
        string $slug
    ): JsonResponse {

        $blog = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name,image,description,twitter_url,facebook_url,linkedin_url',
            ])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        /*
         * Latest published blogs except current blog.
         */
        $recentBlogs = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()
            ->whereKeyNot($blog->id)
            ->latest('published_at')
            ->limit(4)
            ->get();

  
        $relatedBlogs = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()
            ->whereKeyNot($blog->id)
            ->where(
                'category_id',
                $blog->category_id
            )
            ->latest('published_at')
            ->limit(3)
            ->get();

        /*
         * Older published blog.
         */
        $previousBlog = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()
            ->where(
                'published_at',
                '<',
                $blog->published_at
            )
            ->latest('published_at')
            ->first();

        /*
         * Newer published blog.
         */
        $nextBlog = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()
            ->where(
                'published_at',
                '>',
                $blog->published_at
            )
            ->oldest('published_at')
            ->first();

        return response()->json([
            'success' => true,

            'message' =>
                'Blog details retrieved successfully.',

            'blog' => (
                new BlogDetailResource($blog)
            )->resolve($request),

            'recent_blogs' =>
                BlogCardResource::collection(
                    $recentBlogs
                )->resolve($request),

            'related_blogs' =>
                BlogCardResource::collection(
                    $relatedBlogs
                )->resolve($request),

            'previous_blog' => $previousBlog
                ? (
                    new BlogCardResource($previousBlog)
                )->resolve($request)
                : null,

            'next_blog' => $nextBlog
                ? (
                    new BlogCardResource($nextBlog)
                )->resolve($request)
                : null,
        ]);
    }
}