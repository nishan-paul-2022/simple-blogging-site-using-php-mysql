<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Get comments for a post.
     */
    public function index(Post $post, Request $request): JsonResponse
    {
        $comments = $post->comments()
            ->approved()
            ->whereNull('parent_id')
            ->with(['user', 'replies'])
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'data' => $comments->items(),
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
                'last_page' => $comments->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new comment.
     */
    public function store(Post $post, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email',
            'content' => 'required|string|min:5|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $validated['post_id'] = $post->id;
        $validated['user_id'] = auth()->id();

        $comment = Comment::create($validated);

        return response()->json([
            'data' => $comment,
            'message' => 'Comment created. It will be visible after approval.',
        ], 201);
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }

    /**
     * Approve a comment (admin only).
     */
    public function approve(Comment $comment): JsonResponse
    {
        $this->authorize('approve', $comment);

        $comment->update(['is_approved' => true]);

        return response()->json([
            'data' => $comment,
            'message' => 'Comment approved',
        ]);
    }
}
