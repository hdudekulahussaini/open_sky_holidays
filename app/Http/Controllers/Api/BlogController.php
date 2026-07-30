<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCardResource;
use App\Http\Resources\BlogDetailResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class BlogController extends Controller
{
    #[OA\Get(
        path: '/api/blogs',
        summary: 'List published travel blogs',
        description: 'Retrieves a paginated list of published travel blogs with category and search filtering.',
        tags: ['Blogs'],
        parameters: [
            new OA\Parameter(name: 'category', in: 'query', required: false, description: 'Filter by category slug', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'search', in: 'query', required: false, description: 'Search title or content', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, description: 'Items per page (default 6)', schema: new OA\Schema(type: 'integer', default: 6)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated list of blogs',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Blog')),
                    ]
                )
            ),
        ]
    )]
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


    #[OA\Get(
        path: '/api/blogs/{slug}',
        summary: 'Get single blog details by slug',
        description: 'Retrieves complete blog post details including author info, recent blogs, and related posts.',
        tags: ['Blogs'],
        parameters: [
            new OA\Parameter(name: 'slug', in: 'path', required: true, description: 'Slug of the blog post', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Blog details retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Blog details retrieved successfully.'),
                        new OA\Property(property: 'blog', ref: '#/components/schemas/Blog'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Blog post not found'),
        ]
    )]
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