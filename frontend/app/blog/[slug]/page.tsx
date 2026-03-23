'use client';

import { useState, useEffect, useCallback } from 'react';
import { motion } from 'framer-motion';
import { Badge } from '@/components/ui/Badge';
import { Button } from '@/components/ui/Button';
import Link from 'next/link';
import Image from 'next/image';
import CommentsSection from '@/components/CommentsSection';
import { Post } from '@/lib/api';

export default function BlogPostPage({ params }: { params: { slug: string } }) {
  const [post, setPost] = useState<Post | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [relatedPosts, setRelatedPosts] = useState<Post[]>([]);

  const fetchPost = useCallback(async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/posts/${params.slug}`, {
        method: 'GET',
      });

      if (!response.ok) throw new Error('Post not found');

      const data = await response.json();
      setPost(data.data);

      // Fetch related posts
      const relatedResponse = await fetch(
        `${process.env.NEXT_PUBLIC_API_URL}/posts/${data.data.id}/related?limit=3`,
        { method: 'GET' }
      );

      if (relatedResponse.ok) {
        const relatedData = await relatedResponse.json();
        setRelatedPosts(relatedData.data);
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to load post');
    } finally {
      setLoading(false);
    }
  }, [params.slug]);

  useEffect(() => {
    fetchPost();
  }, [fetchPost]);

  if (loading) {
    return (
      <main className="min-h-screen flex items-center justify-center">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600" />
      </main>
    );
  }

  if (error || !post) {
    return (
      <main className="min-h-screen flex items-center justify-center bg-slate-50">
        <div className="text-center">
          <h1 className="text-2xl font-bold text-slate-900 mb-4">{error || 'Post not found'}</h1>
          <Button asChild>
            <Link href="/blog">Back to Blog</Link>
          </Button>
        </div>
      </main>
    );
  }

  const formattedDate = post.created_at
    ? new Date(post.created_at).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      })
    : '';

  return (
    <main className="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-12">
      <article className="mx-auto max-w-4xl px-4">
        {/* Header */}
        <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} className="mb-8">
          <div className="flex items-center gap-2 mb-4">
            {post.category && <Badge variant="primary">{post.category.name}</Badge>}
          </div>

          <h1 className="text-4xl md:text-5xl font-bold mb-4 leading-tight">{post.title}</h1>

          <div className="flex flex-wrap items-center gap-4 text-slate-600 mb-6">
            {post.user && (
              <span className="flex items-center gap-2">
                <span className="text-2xl">👤</span>
                <span>{post.user.name}</span>
              </span>
            )}
            {formattedDate && (
              <span className="flex items-center gap-2">
                <span className="text-2xl">📅</span>
                <span>{formattedDate}</span>
              </span>
            )}
            {post.views !== undefined && (
              <span className="flex items-center gap-2">
                <span className="text-2xl">👁️</span>
                <span>{post.views} views</span>
              </span>
            )}
          </div>
        </motion.div>

        {/* Featured Image */}
        {post.featured_image && (
          <motion.div
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            className="mb-8 rounded-lg overflow-hidden shadow-lg h-96 bg-slate-200 relative"
          >
            <Image
              src={post.featured_image}
              alt={post.title}
              fill
              className="object-cover"
              sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
            />
          </motion.div>
        )}

        {/* Content */}
        <motion.div
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          className="prose prose-lg max-w-none mb-12 bg-white p-8 rounded-lg shadow-md"
        >
          <div
            className="text-slate-700 leading-relaxed"
            dangerouslySetInnerHTML={{ __html: post.content }}
          />
        </motion.div>

        {/* Tags */}
        {post.tags && post.tags.length > 0 && (
          <motion.div
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            className="mb-12 p-6 bg-white rounded-lg shadow-md"
          >
            <h3 className="font-semibold mb-3">Tags</h3>
            <div className="flex flex-wrap gap-2">
              {post.tags.map((tag) => (
                <Link key={tag.slug} href={`/tags/${tag.slug}`}>
                  <Badge variant="secondary">{tag.name}</Badge>
                </Link>
              ))}
            </div>
          </motion.div>
        )}

        {/* Related Posts */}
        {relatedPosts.length > 0 && (
          <motion.div initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} className="mb-12">
            <h2 className="text-3xl font-bold mb-6">Related Posts</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {relatedPosts.map((relatedPost) => (
                <Link key={relatedPost.slug} href={`/blog/${relatedPost.slug}`}>
                  <div className="p-4 bg-white rounded-lg border border-slate-200 hover:shadow-lg transition-shadow cursor-pointer h-full">
                    <h3 className="font-bold line-clamp-2 mb-2">{relatedPost.title}</h3>
                    <p className="text-sm text-slate-600 line-clamp-2">{relatedPost.excerpt}</p>
                  </div>
                </Link>
              ))}
            </div>
          </motion.div>
        )}

        {/* Comments Section */}
        {post.id && <CommentsSection postId={post.id} />}

        {/* Back Button */}
        <motion.div initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} className="mt-8">
          <Button variant="secondary" asChild>
            <Link href="/blog">← Back to Blog</Link>
          </Button>
        </motion.div>
      </article>
    </main>
  );
}
