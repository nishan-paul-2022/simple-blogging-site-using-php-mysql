'use client';

import Link from 'next/link';
import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Button } from './ui/Button';

export function Header() {
  const [isOpen, setIsOpen] = useState(false);

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
          <Link href="/categories" className="text-slate-600 hover:text-slate-900 transition-colors">
            Categories
          </Link>
          <Link href="/about" className="text-slate-600 hover:text-slate-900 transition-colors">
            About
          </Link>
        </div>

        {/* Auth Buttons */}
        <div className="hidden md:flex items-center gap-3">
          <Button variant="ghost" size="sm" asChild>
            <Link href="/auth/login">Sign In</Link>
          </Button>
          <Button size="sm" asChild>
            <Link href="/auth/signup">Get Started</Link>
          </Button>
        </div>

        {/* Mobile Menu Button */}
        <button
          className="md:hidden p-2 hover:bg-slate-100 rounded-lg transition-colors"
          onClick={() => setIsOpen(!isOpen)}
        >
          <svg
            className="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
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
            <div className="flex gap-2 pt-3">
              <Button variant="secondary" size="sm" fullWidth asChild>
                <Link href="/auth/login">Sign In</Link>
              </Button>
              <Button size="sm" fullWidth asChild>
                <Link href="/auth/signup">Get Started</Link>
              </Button>
            </div>
          </div>
        </motion.div>
      )}
    </header>
  );
}
