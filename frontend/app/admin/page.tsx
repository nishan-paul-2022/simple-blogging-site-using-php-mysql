'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { motion } from 'framer-motion';
import { Card } from '@/components/ui/Card';

interface Stats {
  totalPosts: number;
  totalUsers: number;
  totalComments: number;
  totalCategories: number;
}

export default function AdminDashboard() {
  const [stats, setStats] = useState<Stats>({
    totalPosts: 0,
    totalUsers: 0,
    totalComments: 0,
    totalCategories: 0,
  });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchStats();
  }, []);

  const fetchStats = async () => {
    try {
      const token = localStorage.getItem('authToken');
      if (!token) return;

      // Due to API limitations, we'll fetch from individual endpoints
      const [postsRes, categoriesRes] = await Promise.all([
        fetch(`${process.env.NEXT_PUBLIC_API_URL}/posts?per_page=1`, {
          headers: { Authorization: `Bearer ${token}` },
        }),
        fetch(`${process.env.NEXT_PUBLIC_API_URL}/categories`, {
          headers: { Authorization: `Bearer ${token}` },
        }),
      ]);

      if (!postsRes.ok || !categoriesRes.ok) {
        throw new Error('Failed to fetch stats');
      }

      const postsData = await postsRes.json();
      const categoriesData = await categoriesRes.json();

      setStats({
        totalPosts: postsData.meta?.total || 0,
        totalUsers: 10, // Placeholder - would need stats endpoint
        totalComments: 100, // Placeholder - would need stats endpoint
        totalCategories: categoriesData.data?.length || 0,
      });
    } catch (err) {
      setError('Failed to load statistics');
    } finally {
      setLoading(false);
    }
  };

  const statCards = [
    {
      label: 'Total Posts',
      value: stats.totalPosts,
      icon: '📝',
      href: '/admin/posts',
      color: 'from-blue-500 to-blue-600',
    },
    {
      label: 'Total Categories',
      value: stats.totalCategories,
      icon: '🏷️',
      href: '/admin/categories',
      color: 'from-green-500 to-green-600',
    },
    {
      label: 'Total Users',
      value: stats.totalUsers,
      icon: '👥',
      href: '#',
      color: 'from-purple-500 to-purple-600',
    },
    {
      label: 'Total Comments',
      value: stats.totalComments,
      icon: '💬',
      href: '/admin/comments',
      color: 'from-orange-500 to-orange-600',
    },
  ];

  return (
    <div>
      {/* Page Header */}
      <div className="mb-8">
        <h1 className="text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p className="text-gray-600">Welcome back! Here's an overview of your blog.</p>
      </div>

      {error && (
        <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
          {error}
        </div>
      )}

      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {statCards.map((card, idx) => (
          <motion.div
            key={card.label}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: idx * 0.1 }}
          >
            <Link href={card.href}>
              <div className={`bg-gradient-to-br ${card.color} rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow cursor-pointer`}>
                <div className="flex items-center justify-between mb-4">
                  <span className="text-4xl">{card.icon}</span>
                  <span className="text-3xl font-bold">
                    {loading ? '-' : card.value}
                  </span>
                </div>
                <p className="text-white/80">{card.label}</p>
              </div>
            </Link>
          </motion.div>
        ))}
      </div>

      {/* Quick Actions */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.4 }}
      >
        <Card>
          <Card.Header>
            <Card.Title>Quick Actions</Card.Title>
            <Card.Description>Common admin tasks</Card.Description>
          </Card.Header>
          <Card.Content>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <Link
                href="/admin/posts"
                className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <div className="text-2xl mb-2">📝</div>
                <h3 className="font-semibold text-gray-900">Manage Posts</h3>
                <p className="text-sm text-gray-600">Create, edit, or delete posts</p>
              </Link>

              <Link
                href="#"
                className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <div className="text-2xl mb-2">➕</div>
                <h3 className="font-semibold text-gray-900">Create Post</h3>
                <p className="text-sm text-gray-600">Write a new blog post</p>
              </Link>

              <Link
                href="/admin/categories"
                className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <div className="text-2xl mb-2">🏷️</div>
                <h3 className="font-semibold text-gray-900">Categories</h3>
                <p className="text-sm text-gray-600">Manage blog categories</p>
              </Link>

              <Link
                href="/admin/comments"
                className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <div className="text-2xl mb-2">💬</div>
                <h3 className="font-semibold text-gray-900">Comments</h3>
                <p className="text-sm text-gray-600">Moderate user comments</p>
              </Link>

              <Link
                href="/profile"
                className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <div className="text-2xl mb-2">👤</div>
                <h3 className="font-semibold text-gray-900">My Profile</h3>
                <p className="text-sm text-gray-600">Edit your profile</p>
              </Link>

              <Link
                href="/"
                className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
              >
                <div className="text-2xl mb-2">🏠</div>
                <h3 className="font-semibold text-gray-900">View Site</h3>
                <p className="text-sm text-gray-600">Go to blog homepage</p>
              </Link>
            </div>
          </Card.Content>
        </Card>
      </motion.div>

      {/* Help Section */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.5 }}
        className="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg"
      >
        <h3 className="font-semibold text-blue-900 mb-2">Need Help?</h3>
        <p className="text-blue-800 text-sm">
          Check out the <a href="#" className="underline hover:text-blue-900">documentation</a> or{' '}
          <a href="mailto:support@expresso.com" className="underline hover:text-blue-900">contact support</a>.
        </p>
      </motion.div>
    </div>
  );
}
