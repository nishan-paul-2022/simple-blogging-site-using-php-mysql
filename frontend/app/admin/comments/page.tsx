'use client';

import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/Button';
import { Card } from '@/components/ui/Card';

interface Comment {
  id: number;
  content: string;
  approved: boolean;
  post?: {
    id: number;
    title: string;
  };
  user?: {
    name: string;
  };
  created_at: string;
}

export default function AdminCommentsPage() {
  const router = useRouter();
  const [comments, setComments] = useState<Comment[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [filter, setFilter] = useState<'all' | 'pending' | 'approved'>('all');

  useEffect(() => {
    fetchComments();
  }, [filter]);

  const fetchComments = async () => {
    try {
      const token = localStorage.getItem('authToken');
      if (!token) {
        router.push('/auth/login');
        return;
      }

      // Note: API may not have separate comments endpoint, this would need to be implemented
      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/comments?per_page=50`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      if (!res.ok) {
        throw new Error('Failed to fetch comments');
      }

      const data = await res.json();
      const allComments = data.data || [];

      // Client-side filtering if API doesn't support it
      let filtered = allComments;
      if (filter === 'pending') {
        filtered = allComments.filter((c: Comment) => !c.approved);
      } else if (filter === 'approved') {
        filtered = allComments.filter((c: Comment) => c.approved);
      }

      setComments(filtered);
    } catch (err) {
      setError('Failed to load comments');
    } finally {
      setLoading(false);
    }
  };

  const handleApprove = async (id: number) => {
    try {
      const token = localStorage.getItem('authToken');
      if (!token) return;

      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/comments/${id}/approve`, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      if (res.ok) {
        setComments(comments.map((c) => (c.id === id ? { ...c, approved: true } : c)));
      } else {
        setError('Failed to approve comment');
      }
    } catch (err) {
      setError('Error approving comment');
    }
  };

  const handleDelete = async (id: number) => {
    if (!window.confirm('Are you sure you want to delete this comment?')) {
      return;
    }

    try {
      const token = localStorage.getItem('authToken');
      if (!token) return;

      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/comments/${id}`, {
        method: 'DELETE',
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      if (res.ok) {
        setComments(comments.filter((c) => c.id !== id));
      } else {
        setError('Failed to delete comment');
      }
    } catch (err) {
      setError('Error deleting comment');
    }
  };

  return (
    <div>
      {/* Page Header */}
      <div className="mb-8">
        <h1 className="text-4xl font-bold text-gray-900 mb-2">Comments</h1>
        <p className="text-gray-600">Moderate user comments</p>
      </div>

      {error && (
        <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
          {error}
        </div>
      )}

      {/* Filters */}
      <div className="mb-6 flex gap-2">
        <Button
          variant={filter === 'all' ? 'primary' : 'secondary'}
          onClick={() => setFilter('all')}
        >
          All Comments
        </Button>
        <Button
          variant={filter === 'pending' ? 'primary' : 'secondary'}
          onClick={() => setFilter('pending')}
        >
          Pending
        </Button>
        <Button
          variant={filter === 'approved' ? 'primary' : 'secondary'}
          onClick={() => setFilter('approved')}
        >
          Approved
        </Button>
      </div>

      {/* Comments List */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.3 }}
        className="space-y-4"
      >
        {loading ? (
          <Card>
            <Card.Content className="py-12 text-center">
              <p className="text-gray-500">Loading comments...</p>
            </Card.Content>
          </Card>
        ) : comments.length === 0 ? (
          <Card>
            <Card.Content className="py-12 text-center">
              <p className="text-gray-500">
                {filter === 'pending' ? 'No pending comments' : 'No comments found'}
              </p>
            </Card.Content>
          </Card>
        ) : (
          comments.map((comment) => (
            <motion.div key={comment.id} initial={{ opacity: 0 }} animate={{ opacity: 1 }}>
              <Card>
                <Card.Header>
                  <div className="flex items-start justify-between">
                    <div>
                      <Card.Title className="text-base">
                        {comment.user?.name || 'Anonymous'}
                      </Card.Title>
                      <Card.Description>
                        {comment.post?.title && (
                          <>
                            On: <strong>{comment.post.title}</strong>
                          </>
                        )}
                      </Card.Description>
                    </div>
                    <span
                      className={`inline-block px-3 py-1 rounded-full text-xs font-medium ${
                        comment.approved
                          ? 'bg-green-100 text-green-800'
                          : 'bg-yellow-100 text-yellow-800'
                      }`}
                    >
                      {comment.approved ? 'Approved' : 'Pending'}
                    </span>
                  </div>
                </Card.Header>

                <Card.Content>
                  <p className="text-gray-700 mb-4">{comment.content}</p>
                  <p className="text-sm text-gray-500">
                    {new Date(comment.created_at).toLocaleString()}
                  </p>
                </Card.Content>

                <Card.Footer className="flex gap-2">
                  {!comment.approved && (
                    <Button
                      size="sm"
                      variant="outline"
                      onClick={() => handleApprove(comment.id)}
                      className="flex-1"
                    >
                      Approve
                    </Button>
                  )}
                  <Button
                    size="sm"
                    variant="ghost"
                    onClick={() => handleDelete(comment.id)}
                    className="text-red-600 hover:text-red-700 flex-1"
                  >
                    Delete
                  </Button>
                </Card.Footer>
              </Card>
            </motion.div>
          ))
        )}
      </motion.div>
    </div>
  );
}
