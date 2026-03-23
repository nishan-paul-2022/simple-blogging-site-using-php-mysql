<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories.
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::with('posts')
            ->withCount(['posts' => function ($q) {
                $q->published();
            }])
            ->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    /**
     * Get posts in a category.
     */
    public function posts(Category $category, Request $request): JsonResponse
    {
        $posts = $category->publishedPosts()
            ->with(['user', 'tags'])
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
     * Get category by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return response()->json([
            'data' => $category,
        ]);
    }

    /**
     * Create a new category (admin only).
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
            'image' => 'nullable|url',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'data' => $category,
            'message' => 'Category created successfully',
        ], 201);
    }

    /**
     * Update a category.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => "required|string|max:255|unique:categories,name,{$category->id}",
            'description' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
            'image' => 'nullable|url',
        ]);

        $category->update($validated);

        return response()->json([
            'data' => $category,
            'message' => 'Category updated successfully',
        ]);
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
