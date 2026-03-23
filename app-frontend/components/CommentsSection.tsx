'use client';

import { useEffect, useState, FormEvent, useCallback } from 'react';
import { motion } from 'framer-motion';
import { Button, buttonVariants } from '@/components/ui/Button';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/Card';
import { Comment } from '@/lib/api';

interface CommentsClientProps {
  postId: number;
}

export default function CommentsSection({ postId }: CommentsClientProps) {
  const [comments, setComments] = useState<Comment[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [commentContent, setCommentContent] = useState('');
  const [submitting, setSubmitting] = useState(false);

  const fetchComments = useCallback(async () => {
    try {
      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/posts/${postId}/comments`);

      if (!res.ok) {
        throw new Error('Failed to fetch comments');
      }

      const data = await res.json();
      // Filter to show only approved comments to non-admins
      const allComments = data.data || [];
      const approvedComments = allComments.filter((c: Comment) => c.approved);
      setComments(approvedComments);
    } catch {
      setError('Failed to load comments');
    } finally {
      setLoading(false);
    }
  }, [postId]);

  useEffect(() => {
    const token = localStorage.getItem('token');
    setIsAuthenticated(!!token);
    fetchComments();
  }, [postId, fetchComments]);

  const handleSubmitComment = async (e: FormEvent) => {
    e.preventDefault();

    if (!isAuthenticated) {
      window.location.href = '/auth/login';
      return;
    }

    if (!commentContent.trim()) {
      setError('Comment cannot be empty');
      return;
    }

    setSubmitting(true);
    setError('');

    try {
      const token = localStorage.getItem('token');
      if (!token) {
        window.location.href = '/auth/login';
        return;
      }

      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          content: commentContent,
        }),
      });

      if (!res.ok) {
        throw new Error('Failed to post comment');
      }

      setCommentContent('');
      fetchComments();
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to post comment');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <section className="mt-12">
      <h2 className="text-2xl font-bold text-gray-900 mb-6">Comments</h2>

      {/* Error Message */}
      {error && (
        <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
          {error}
        </div>
      )}

      {/* Comment Form */}
      {isAuthenticated ? (
        <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} className="mb-8">
          <Card>
            <CardHeader>
              <CardTitle>Leave a Comment</CardTitle>
              <CardDescription>Share your thoughts on this post</CardDescription>
            </CardHeader>
            <CardContent>
              <form onSubmit={handleSubmitComment} className="space-y-4">
                <textarea
                  value={commentContent}
                  onChange={(e) => setCommentContent(e.target.value)}
                  placeholder="Write your comment here..."
                  rows={4}
                  disabled={submitting}
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 resize-none"
                />
                <Button
                  type="submit"
                  variant="primary"
                  disabled={submitting || !commentContent.trim()}
                  className={
                    submitting || !commentContent.trim() ? 'opacity-50 cursor-not-allowed' : ''
                  }
                >
                  {submitting ? 'Posting...' : 'Post Comment'}
                </Button>
              </form>
            </CardContent>
          </Card>
        </motion.div>
      ) : (
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-lg text-center"
        >
          <p className="text-blue-900 mb-4">Sign in to leave a comment</p>
          <a href="/auth/login" className={buttonVariants({ variant: 'primary' })}>
            Sign In
          </a>
        </motion.div>
      )}

      {/* Comments List */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.1 }}
        className="space-y-4"
      >
        {loading ? (
          <div className="text-center py-8">
            <p className="text-gray-500">Loading comments...</p>
          </div>
        ) : comments.length === 0 ? (
          <div className="text-center py-8">
            <p className="text-gray-500">No comments yet. Be the first to comment!</p>
          </div>
        ) : (
          comments.map((comment, idx) => (
            <motion.div
              key={comment.id}
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: idx * 0.05 }}
            >
              <Card>
                <CardHeader>
                  <div className="flex items-start gap-4">
                    <div className="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-emerald-500 flex items-center justify-center text-white text-sm font-bold">
                      {comment.user?.name?.charAt(0) || 'A'}
                    </div>
                    <div className="flex-1">
                      <CardTitle className="text-base">
                        {comment.user?.name || 'Anonymous'}
                      </CardTitle>
                      <CardDescription>
                        {new Date(comment.created_at).toLocaleDateString()}{' '}
                        {new Date(comment.created_at).toLocaleTimeString([], {
                          hour: '2-digit',
                          minute: '2-digit',
                        })}
                      </CardDescription>
                    </div>
                  </div>
                </CardHeader>

                <CardContent>
                  <p className="text-gray-700">{comment.content}</p>
                </CardContent>
              </Card>
            </motion.div>
          ))
        )}
      </motion.div>
    </section>
  );
}
