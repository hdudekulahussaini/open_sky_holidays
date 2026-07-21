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
        $blogs = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()

            ->when(
                $request->filled('category'),
                function ($query) use ($request) {
                    $query->whereHas(
                        'category',
                        function ($query) use ($request) {
                            $query->where(
                                'slug',
                                $request->input('category')
                            );
                        }
                    );
                }
            )

            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->input('search');

                    $query->where(
                        function ($query) use ($search) {
                            $query
                                ->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'short_description',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )

            ->latest('published_at')
            ->paginate(6);

        return BlogCardResource::collection($blogs);
    }

    public function show(
        Request $request,
        string $slug
    ): JsonResponse {
        $blog = Blog::query()
            ->with(['category', 'author'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentBlogs = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->limit(4)
            ->get();

        $relatedBlogs = Blog::query()
            ->with([
                'category:id,name,slug',
                'author:id,name',
            ])
            ->published()
            ->where('id', '!=', $blog->id)
            ->where('category_id', $blog->category_id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $previousBlog = Blog::query()
            ->with(['category', 'author'])
            ->published()
            ->where(
                'published_at',
                '<',
                $blog->published_at
            )
            ->latest('published_at')
            ->first();

        $nextBlog = Blog::query()
            ->with(['category', 'author'])
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

            'message' => 'Blog details retrieved successfully.',

            'blog' => (
                new BlogDetailResource($blog)
            )->resolve($request),

            'recent_blogs' => BlogCardResource::collection(
                $recentBlogs
            )->resolve($request),

            'related_blogs' => BlogCardResource::collection(
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
