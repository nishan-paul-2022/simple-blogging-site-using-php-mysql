'use client';

import { useEffect, useState } from 'react';

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
    <main className="flex-1 flex items-center justify-center p-4">
      <div className="max-w-2xl w-full text-center">
        <h1 className="text-4xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-emerald-600 bg-clip-text text-transparent">
          Modern Blog Platform
        </h1>
        
        <p className="text-xl text-slate-600 mb-8">
          Building a modern, responsive blogging experience
        </p>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
          {/* Frontend Status */}
          <div className="p-6 bg-white rounded-lg shadow-md border border-slate-200">
            <div className="text-3xl mb-2">🎨</div>
            <h2 className="text-lg font-semibold mb-2">Frontend</h2>
            <p className="text-sm text-slate-600">Next.js with TypeScript</p>
            <div className="mt-3 inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded">
              ✓ Running
            </div>
          </div>

          {/* Backend Status */}
          <div className="p-6 bg-white rounded-lg shadow-md border border-slate-200">
            <div className="text-3xl mb-2">⚙️</div>
            <h2 className="text-lg font-semibold mb-2">Backend API</h2>
            <p className="text-sm text-slate-600">Laravel 11 REST API</p>
            <div className="mt-3">
              {loading ? (
                <div className="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded">
                  ⏳ Checking...
                </div>
              ) : error ? (
                <div className="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">
                  ✗ Offline
                </div>
              ) : apiStatus?.status === 'ok' ? (
                <div className="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded">
                  ✓ Online
                </div>
              ) : null}
            </div>
          </div>
        </div>

        <div className="mt-12 p-6 bg-gradient-to-r from-purple-50 to-emerald-50 rounded-lg border border-purple-200">
          <h3 className="text-lg font-semibold mb-3">Development Status</h3>
          <div className="text-left space-y-2 text-sm text-slate-700">
            <p>✓ Phase 1: Infrastructure Setup Complete</p>
            <p>◆ Phase 2: Database & Backend Models (Next)</p>
            <p>◆ Phase 3: Frontend Foundation</p>
            <p>◆ Phase 4: Feature Implementation</p>
            <p>◆ Phase 5: Deployment</p>
          </div>
        </div>

        <div className="mt-8">
          <a
            href="http://localhost:8000/api/health"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-emerald-600 text-white font-semibold rounded-lg hover:shadow-lg transition-shadow"
          >
            Check API Health
          </a>
        </div>
      </div>
    </main>
  );
}
