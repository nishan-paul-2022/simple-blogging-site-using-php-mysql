'use client';

import { useState, useEffect, useCallback } from 'react';
import { motion } from 'framer-motion';
import { BlogCard } from '@/components/BlogCard';
import { Button } from '@/components/ui/Button';
import Link from 'next/link';
import { Post } from '@/lib/api';

export default function BlogPage() {
  const [posts, setPosts] = useState<Post[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');

  const fetchPosts = useCallback(async () => {
    try {
      setLoading(true);
      setError(null);

      const params = new URLSearchParams({
        page: page.toString(),
        per_page: '12',
      });

      if (searchTerm) {
        params.append('search', searchTerm);
      }

      const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/posts?${params}`, {
        method: 'GET',
      });

      if (!response.ok) throw new Error('Failed to fetch posts');

      const data = await response.json();

      if (page === 1) {
        setPosts(data.data);
      } else {
        setPosts((prev) => [...prev, ...data.data]);
      }

      setHasMore(data.pagination.current_page < data.pagination.last_page);
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to load posts');
    } finally {
      setLoading(false);
    }
  }, [page, searchTerm]);

  useEffect(() => {
    fetchPosts();
  }, [fetchPosts]);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setPage(1);
  };

  return (
    <main className="min-h-screen py-12 bg-gradient-to-br from-slate-50 via-white to-emerald-50">
      <div className="mx-auto max-w-6xl px-4">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="mb-12"
        >
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            <span className="bg-gradient-to-r from-purple-600 to-emerald-600 bg-clip-text text-transparent">
              Blog Posts
            </span>
          </h1>
          <p className="text-lg text-slate-600 mb-8">
            Discover insightful articles on technology, lifestyle, and more
          </p>

          {/* Search Bar */}
          <form onSubmit={handleSearch} className="flex gap-2 mb-8">
            <input
              type="text"
              placeholder="Search posts..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="flex-1 px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-600"
            />
            <Button type="submit">Search</Button>
          </form>
        </motion.div>

        {/* Error State */}
        {error && (
          <div className="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {error}
          </div>
        )}

        {/* Posts Grid */}
        {posts.length > 0 ? (
          <>
            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12"
            >
              {posts.map((post, index) => (
                <motion.div
                  key={post.slug}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  transition={{ delay: index * 0.1 }}
                  viewport={{ once: true }}
                >
                  <BlogCard
                    title={post.title}
                    excerpt={post.excerpt || ''}
                    slug={post.slug}
                    featuredImage={post.featured_image}
                    category={post.category}
                    author={post.user}
                    tags={post.tags}
                    publishedAt={post.created_at}
                    views={post.views}
                  />
                </motion.div>
              ))}
            </motion.div>

            {/* Load More Button */}
            {hasMore && (
              <motion.div
                initial={{ opacity: 0 }}
                whileInView={{ opacity: 1 }}
                className="flex justify-center"
              >
                <Button onClick={() => setPage((p) => p + 1)} disabled={loading} variant="outline">
                  {loading ? 'Loading...' : 'Load More'}
                </Button>
              </motion.div>
            )}
          </>
        ) : loading ? (
          <div className="flex justify-center items-center py-20">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600" />
          </div>
        ) : (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            className="text-center py-20"
          >
            <p className="text-xl text-slate-600 mb-6">No posts found</p>
            <Button variant="secondary" asChild>
              <Link href="/">Back to Home</Link>
            </Button>
          </motion.div>
        )}
      </div>
    </main>
  );
}
