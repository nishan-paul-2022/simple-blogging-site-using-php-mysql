'use client';

import { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import Link from 'next/link';
import { Badge } from '@/components/ui/Badge';

interface Category {
  id: number;
  name: string;
  slug: string;
  description?: string;
  color: string;
  posts_count: number;
}

export default function CategoriesPage() {
  const [categories, setCategories] = useState<Category[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchCategories();
  }, []);

  const fetchCategories = async () => {
    try {
      const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/categories`, {
        method: 'GET',
      });

      if (!response.ok) throw new Error('Failed to fetch categories');

      const data = await response.json();
      setCategories(data.data);
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to load categories');
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="min-h-screen py-12 bg-gradient-to-br from-slate-50 via-white to-emerald-50">
      <div className="mx-auto max-w-6xl px-4">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="mb-12 text-center"
        >
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            <span className="bg-gradient-to-r from-purple-600 to-emerald-600 bg-clip-text text-transparent">
              Categories
            </span>
          </h1>
          <p className="text-lg text-slate-600">Browse posts by category</p>
        </motion.div>

        {/* Error State */}
        {error && (
          <div className="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {error}
          </div>
        )}

        {/* Categories Grid */}
        {loading ? (
          <div className="flex justify-center items-center py-20">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600" />
          </div>
        ) : categories.length > 0 ? (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
          >
            {categories.map((category, index) => (
              <motion.div
                key={category.slug}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                viewport={{ once: true }}
              >
                <Link href={`/categories/${category.slug}`}>
                  <div
                    className="p-6 rounded-lg border border-slate-200 hover:shadow-lg transition-all duration-300 cursor-pointer h-full"
                    style={{ borderTopColor: category.color, borderTopWidth: '4px' }}
                  >
                    <h3 className="text-xl font-bold mb-2">{category.name}</h3>
                    {category.description && (
                      <p className="text-slate-600 mb-4 line-clamp-2">{category.description}</p>
                    )}
                    <div className="flex items-center justify-between">
                      <Badge variant="secondary">{category.posts_count} posts</Badge>
                      <span className="text-slate-400 text-sm">→</span>
                    </div>
                  </div>
                </Link>
              </motion.div>
            ))}
          </motion.div>
        ) : (
          <div className="text-center py-20">
            <p className="text-xl text-slate-600">No categories found</p>
          </div>
        )}
      </div>
    </main>
  );
}
