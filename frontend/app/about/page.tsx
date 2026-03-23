'use client';

import { motion } from 'framer-motion';
import Link from 'next/link';
import { Button } from '@/components/ui/Button';

export default function AboutPage() {
  return (
    <main className="min-h-screen py-12 bg-gradient-to-br from-slate-50 via-white to-emerald-50">
      <div className="mx-auto max-w-4xl px-4">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="mb-12 text-center"
        >
          <h1 className="text-5xl font-bold mb-4">
            <span className="bg-gradient-to-r from-purple-600 to-emerald-600 bg-clip-text text-transparent">
              About Modern Blog
            </span>
          </h1>
        </motion.div>

        {/* Content Sections */}
        <motion.div
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true }}
          className="prose prose-lg max-w-none space-y-8"
        >
          {/* Vision Section */}
          <div className="gp-6 bg-white rounded-lg shadow-md p-6">
            <h2 className="text-3xl font-bold mb-4">Our Vision</h2>
            <p className="text-slate-700 mb-4">
              Modern Blog is a contemporary blogging platform built with cutting-edge technologies
              to provide writers and readers with an exceptional experience. We believe in the power
              of quality content and community engagement.
            </p>
          </div>

          {/* Technology Section */}
          <div className="bg-white rounded-lg shadow-md p-6">
            <h2 className="text-3xl font-bold mb-4">Technology Stack</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h3 className="text-xl font-semibold mb-3 text-purple-600">Frontend</h3>
                <ul className="space-y-2 text-slate-700">
                  <li>
                    • <strong>Next.js 14</strong> - React framework for production
                  </li>
                  <li>
                    • <strong>TypeScript</strong> - Type-safe development
                  </li>
                  <li>
                    • <strong>Tailwind CSS</strong> - Utility-first styling
                  </li>
                  <li>
                    • <strong>Framer Motion</strong> - Smooth animations
                  </li>
                </ul>
              </div>
              <div>
                <h3 className="text-xl font-semibold mb-3 text-emerald-600">Backend</h3>
                <ul className="space-y-2 text-slate-700">
                  <li>
                    • <strong>Laravel 11</strong> - PHP web framework
                  </li>
                  <li>
                    • <strong>MySQL 8</strong> - Relational database
                  </li>
                  <li>
                    • <strong>Redis</strong> - Caching layer
                  </li>
                  <li>
                    • <strong>Sanctum</strong> - API authentication
                  </li>
                </ul>
              </div>
            </div>
          </div>

          {/* Features Section */}
          <div className="bg-white rounded-lg shadow-md p-6">
            <h2 className="text-3xl font-bold mb-4">Features</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div className="flex gap-3">
                <span className="text-2xl">📝</span>
                <div>
                  <h4 className="font-semibold">Rich Editor</h4>
                  <p className="text-sm text-slate-600">Write beautiful posts with rich text</p>
                </div>
              </div>
              <div className="flex gap-3">
                <span className="text-2xl">📁</span>
                <div>
                  <h4 className="font-semibold">Organization</h4>
                  <p className="text-sm text-slate-600">Organize content with categories</p>
                </div>
              </div>
              <div className="flex gap-3">
                <span className="text-2xl">🏷️</span>
                <div>
                  <h4 className="font-semibold">Tagging System</h4>
                  <p className="text-sm text-slate-600">Tag posts for better discovery</p>
                </div>
              </div>
              <div className="flex gap-3">
                <span className="text-2xl">💬</span>
                <div>
                  <h4 className="font-semibold">Comments</h4>
                  <p className="text-sm text-slate-600">Engage with community</p>
                </div>
              </div>
              <div className="flex gap-3">
                <span className="text-2xl">🔍</span>
                <div>
                  <h4 className="font-semibold">Search</h4>
                  <p className="text-sm text-slate-600">Find posts easily</p>
                </div>
              </div>
              <div className="flex gap-3">
                <span className="text-2xl">📱</span>
                <div>
                  <h4 className="font-semibold">Responsive</h4>
                  <p className="text-sm text-slate-600">Perfect on any device</p>
                </div>
              </div>
            </div>
          </div>

          {/* Development Process */}
          <div className="bg-white rounded-lg shadow-md p-6">
            <h2 className="text-3xl font-bold mb-4">Development Approach</h2>
            <p className="text-slate-700 mb-4">
              This project follows a modern development workflow with clear phases, comprehensive
              testing, and continuous deployment strategies. Each feature is developed modularly and
              integrated smoothly with the rest of the system.
            </p>
            <div className="bg-slate-50 p-4 rounded border-l-4 border-purple-600">
              <p className="text-sm text-slate-700">
                <strong>Current Status:</strong> Phase 4 - Frontend implementation in progress. The
                foundation is solid, and we&apos;re actively building out user-facing features.
              </p>
            </div>
          </div>
        </motion.div>

        {/* CTA Section */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="mt-12 text-center"
        >
          <h3 className="text-2xl font-bold mb-6">Ready to Explore?</h3>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="lg" asChild>
              <Link href="/blog">Read Blog</Link>
            </Button>
            <Button size="lg" variant="outline" asChild>
              <Link href="/">Back to Home</Link>
            </Button>
          </div>
        </motion.div>
      </div>
    </main>
  );
}
