<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Get all tags.
     */
    public function index(Request $request): JsonResponse
    {
        $tags = Tag::with('posts')
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->orderByDesc('post_count')
            ->get();

        return response()->json([
            'data' => $tags,
        ]);
    }

    /**
     * Get posts with a tag.
     */
    public function posts(Tag $tag, Request $request): JsonResponse
    {
        $posts = $tag->publishedPosts()
            ->with(['user', 'category'])
            ->latest()
            ->paginate($request->get('per_page', 12));

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
     * Get tag by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        return response()->json([
            'data' => $tag,
        ]);
    }

    /**
     * Autocomplete tags.
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $search = $request->get('q', '');

        $tags = Tag::where('name', 'like', "%$search%")
            ->select('id', 'name', 'slug')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $tags,
        ]);
    }
}
