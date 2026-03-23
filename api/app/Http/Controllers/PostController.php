<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Get all published posts with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Post::published()
            ->with(['user', 'category', 'tags'])
            ->latest();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) {
                $q->where('slug', request('tag'));
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
            });
        }

        $posts = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'last_page' => $posts->lastPage(),
            ],
        ]);
    }

    /**
     * Get featured posts.
     */
    public function featured(Request $request): JsonResponse
    {
        $posts = Post::featured()
            ->with(['user', 'category', 'tags'])
            ->limit(6)
            ->get();

        return response()->json([
            'data' => $posts,
        ]);
    }

    /**
     * Get popular posts.
     */
    public function popular(Request $request): JsonResponse
    {
        $posts = Post::popular()
            ->with(['user', 'category', 'tags'])
            ->limit($request->get('limit', 10))
            ->get();

        return response()->json([
            'data' => $posts,
        ]);
    }

    /**
     * Get a single post by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['user', 'category', 'tags', 'comments' => function ($q) {
                $q->approved()->latest();
            }])
            ->firstOrFail();

        // Increment views
        $post->increment('views');

        return response()->json([
            'data' => $post,
        ]);
    }

    /**
     * Create a new post.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|url',
        ]);

        $post = auth()->user()->posts()->create($validated);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return response()->json([
            'data' => $post,
            'message' => 'Post created successfully',
        ], 201);
    }

    /**
     * Update a post.
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'sometimes|in:draft,published,archived',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|url',
        ]);

        if (isset($validated['status']) && $validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return response()->json([
            'data' => $post,
            'message' => 'Post updated successfully',
        ]);
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }

    /**
     * Get related posts.
     */
    public function related(Post $post, Request $request): JsonResponse
    {
        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->with(['user', 'category', 'tags'])
            ->limit($request->get('limit', 5))
            ->get();

        return response()->json([
            'data' => $related,
        ]);
    }
}
