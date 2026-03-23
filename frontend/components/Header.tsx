'use client';

import Link from 'next/link';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { motion } from 'framer-motion';
import { Button } from './ui/Button';

export function Header() {
  const router = useRouter();
  const [isOpen, setIsOpen] = useState(false);
  const [isAuthenticated, setIsAuthenticated] = useState(() => {
    if (typeof window === 'undefined') {
      return false;
    }

    return !!localStorage.getItem('authToken');
  });
  const [userMenuOpen, setUserMenuOpen] = useState(false);

  const handleLogout = () => {
    localStorage.removeItem('authToken');
    setIsAuthenticated(false);
    setUserMenuOpen(false);
    router.push('/');
  };

  return (
    <header className="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/60">
      <nav className="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
        {/* Logo */}
        <Link href="/">
          <motion.div
            whileHover={{ scale: 1.05 }}
            className="flex items-center gap-2 cursor-pointer"
          >
            <div className="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-600 to-emerald-600 flex items-center justify-center">
              <span className="text-white font-bold">📝</span>
            </div>
            <span className="hidden sm:inline font-bold text-lg bg-gradient-to-r from-purple-600 to-emerald-600 bg-clip-text text-transparent">
              Modern Blog
            </span>
          </motion.div>
        </Link>

        {/* Desktop Navigation */}
        <div className="hidden md:flex items-center gap-8">
          <Link href="/blog" className="text-slate-600 hover:text-slate-900 transition-colors">
            Blog
          </Link>
          <Link
            href="/categories"
            className="text-slate-600 hover:text-slate-900 transition-colors"
          >
            Categories
          </Link>
          <Link href="/about" className="text-slate-600 hover:text-slate-900 transition-colors">
            About
          </Link>
        </div>

        {/* Auth Buttons */}
        <div className="hidden md:flex items-center gap-3">
          {isAuthenticated ? (
            <div className="relative">
              <button
                onClick={() => setUserMenuOpen(!userMenuOpen)}
                className="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-slate-100 transition-colors"
              >
                <div className="w-6 h-6 rounded-full bg-gradient-to-r from-purple-500 to-emerald-500 flex items-center justify-center text-white text-xs font-bold">
                  U
                </div>
                <svg
                  className={`w-4 h-4 transition-transform ${userMenuOpen ? 'rotate-180' : ''}`}
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M19 14l-7 7m0 0l-7-7m7 7V3"
                  />
                </svg>
              </button>

              {/* Dropdown Menu */}
              {userMenuOpen && (
                <motion.div
                  initial={{ opacity: 0, y: -10 }}
                  animate={{ opacity: 1, y: 0 }}
                  className="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden"
                >
                  <Link
                    href="/profile"
                    className="block px-4 py-2 text-slate-700 hover:bg-slate-50"
                    onClick={() => setUserMenuOpen(false)}
                  >
                    View Profile
                  </Link>
                  <button
                    onClick={handleLogout}
                    className="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"
                  >
                    Sign Out
                  </button>
                </motion.div>
              )}
            </div>
          ) : (
            <>
              <Button variant="ghost" size="sm" asChild>
                <Link href="/auth/login">Sign In</Link>
              </Button>
              <Button size="sm" asChild>
                <Link href="/auth/signup">Get Started</Link>
              </Button>
            </>
          )}
        </div>

        {/* Mobile Menu Button */}
        <button
          className="md:hidden p-2 hover:bg-slate-100 rounded-lg transition-colors"
          onClick={() => setIsOpen(!isOpen)}
        >
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth={2}
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </nav>

      {/* Mobile Menu */}
      {isOpen && (
        <motion.div
          initial={{ opacity: 0, y: -10 }}
          animate={{ opacity: 1, y: 0 }}
          exit={{ opacity: 0, y: -10 }}
          className="md:hidden border-t border-slate-200 bg-slate-50"
        >
          <div className="px-4 py-4 space-y-3">
            <Link href="/blog" className="block text-slate-600 hover:text-slate-900">
              Blog
            </Link>
            <Link href="/categories" className="block text-slate-600 hover:text-slate-900">
              Categories
            </Link>
            <Link href="/about" className="block text-slate-600 hover:text-slate-900">
              About
            </Link>
            <div className="flex gap-2 pt-3 border-t border-slate-200">
              {isAuthenticated ? (
                <>
                  <Button size="sm" fullWidth asChild>
                    <Link href="/profile">Profile</Link>
                  </Button>
                  <Button
                    size="sm"
                    fullWidth
                    variant="secondary"
                    onClick={() => {
                      handleLogout();
                      setIsOpen(false);
                    }}
                  >
                    Sign Out
                  </Button>
                </>
              ) : (
                <>
                  <Button variant="secondary" size="sm" fullWidth asChild>
                    <Link href="/auth/login">Sign In</Link>
                  </Button>
                  <Button size="sm" fullWidth asChild>
                    <Link href="/auth/signup">Get Started</Link>
                  </Button>
                </>
              )}
            </div>
          </div>
        </motion.div>
      )}
    </header>
  );
}
