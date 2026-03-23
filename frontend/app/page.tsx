'use client';

import { useEffect, useState } from 'react';
import { Hero } from '@/components/Hero';
import { Button } from '@/components/ui/Button';

export default function Home() {
  const [apiStatus, setApiStatus] = useState<{ status: string } | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const checkApi = async () => {
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api'}/health`,
          { method: 'GET' }
        );
        const data = await response.json();
        setApiStatus(data);
      } catch (err) {
        setError(err instanceof Error ? err.message : 'Failed to connect to API');
      } finally {
        setLoading(false);
      }
    };

    checkApi();
  }, []);

  return (
    <>
      {/* Hero Section */}
      <Hero
        title="Welcome to Modern Blog"
        subtitle="Next Generation Blogging"
        description="A cutting-edge blogging platform built with Next.js, Laravel, and Tailwind CSS. Discover, read, and share amazing content with a beautiful, responsive interface."
        ctaText="Explore Blog"
        ctaHref="/blog"
        secondaryCta={{
          text: 'Learn More',
          href: '#features',
        }}
      />

      {/* Status Section */}
      <section className="py-16 bg-white">
        <div className="mx-auto max-w-6xl px-4">
          <h2 className="text-3xl font-bold mb-12 text-center">System Status</h2>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {/* Frontend Status */}
            <div className="p-8 rounded-lg border-2 border-emerald-200 bg-emerald-50">
              <div className="flex items-start">
                <div className="text-4xl mr-4">🎨</div>
                <div>
                  <h3 className="text-xl font-bold mb-2">Frontend</h3>
                  <p className="text-slate-600 mb-4">Next.js 14 with TypeScript</p>
                  <div className="inline-block px-4 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-lg">
                    ✓ Running
                  </div>
                </div>
              </div>
            </div>

            {/* Backend Status */}
            <div
              className={`p-8 rounded-lg border-2 ${
                error ? 'border-red-200 bg-red-50' : 'border-emerald-200 bg-emerald-50'
              }`}
            >
              <div className="flex items-start">
                <div className="text-4xl mr-4">⚙️</div>
                <div>
                  <h3 className="text-xl font-bold mb-2">Backend API</h3>
                  <p className="text-slate-600 mb-4">Laravel 11 REST API</p>
                  <div>
                    {loading ? (
                      <div className="inline-block px-4 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-lg">
                        ⏳ Checking...
                      </div>
                    ) : error ? (
                      <div className="inline-block px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg">
                        ✗ Offline
                      </div>
                    ) : apiStatus?.status === 'ok' ? (
                      <div className="inline-block px-4 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-lg">
                        ✓ Online
                      </div>
                    ) : null}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="features" className="py-16 bg-slate-50">
        <div className="mx-auto max-w-6xl px-4">
          <h2 className="text-3xl font-bold mb-12 text-center">Features</h2>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="p-6 bg-white rounded-lg border border-slate-200 text-center">
              <div className="text-4xl mb-4">📚</div>
              <h3 className="text-lg font-bold mb-3">Rich Blog Content</h3>
              <p className="text-slate-600">
                Browse through beautifully formatted blog posts with images, tags, and categories.
              </p>
            </div>

            <div className="p-6 bg-white rounded-lg border border-slate-200 text-center">
              <div className="text-4xl mb-4">💬</div>
              <h3 className="text-lg font-bold mb-3">Community Comments</h3>
              <p className="text-slate-600">
                Engage with readers and build a community through nested comment threads.
              </p>
            </div>

            <div className="p-6 bg-white rounded-lg border border-slate-200 text-center">
              <div className="text-4xl mb-4">🚀</div>
              <h3 className="text-lg font-bold mb-3">High Performance</h3>
              <p className="text-slate-600">
                Built on modern technologies for fast loading and smooth user experience.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Development Status */}
      <section className="py-16 bg-gradient-to-br from-purple-600 to-emerald-600 text-white">
        <div className="mx-auto max-w-6xl px-4">
          <h2 className="text-3xl font-bold mb-8 text-center">Development Roadmap</h2>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {[
              { phase: 1, title: 'Infrastructure', status: '✓ Complete' },
              { phase: 2, title: 'Database & API', status: '✓ Complete' },
              { phase: 3, title: 'Frontend Foundation', status: '⏳ In Progress' },
              { phase: 4, title: 'Features & Integration', status: '◆ Next' },
              { phase: 5, title: 'Polish & Deploy', status: '◆ Coming' },
            ].map((item) => (
              <div key={item.phase} className="flex items-center gap-4">
                <div className="text-2xl font-bold">{item.phase}</div>
                <div className="flex-1">
                  <h3 className="font-semibold">{item.title}</h3>
                  <p className="text-sm opacity-80">{item.status}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-white">
        <div className="mx-auto max-w-2xl px-4 text-center">
          <h2 className="text-3xl font-bold mb-4">Ready to Explore?</h2>
          <p className="text-lg text-slate-600 mb-8">
            Discover amazing blog posts, connect with authors, and share your thoughts with the
            community.
          </p>
          <Button size="lg" asChild>
            <a href="/blog">Start Reading</a>
          </Button>
        </div>
      </section>
    </>
  );
}
