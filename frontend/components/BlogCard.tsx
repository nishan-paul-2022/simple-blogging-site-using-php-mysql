'use client';

import { motion } from 'framer-motion';
import Link from 'next/link';
import React from 'react';
import Image from 'next/image';
import { Badge } from './ui/Badge';
import { Category, Tag } from '@/lib/api';

interface BlogCardProps {
  title: string;
  excerpt: string;
  slug: string;
  featuredImage?: string;
  category?: Category;
  author?: { name: string };
  tags?: Tag[];
  publishedAt?: string;
  views?: number;
}

export function BlogCard({
  title,
  excerpt,
  slug,
  featuredImage,
  category,
  author,
  tags = [],
  publishedAt,
  views,
}: BlogCardProps) {
  const formattedDate = publishedAt
    ? new Date(publishedAt).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
      })
    : '';

  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.3 }}
      viewport={{ once: true }}
    >
      <Link href={`/blog/${slug}`}>
        <article className="group cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm hover:shadow-lg transition-all duration-300 h-full flex flex-col">
          {/* Featured Image */}
          {featuredImage && (
            <div className="relative h-48 overflow-hidden bg-slate-100">
              <Image
                src={featuredImage}
                alt={title}
                fill
                className="object-cover group-hover:scale-105 transition-transform duration-300"
                sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
              />
              {category && (
                <div className="absolute top-3 left-3 z-10">
                  <Badge variant="primary">{category.name}</Badge>
                </div>
              )}
            </div>
          )}

          {/* Content */}
          <div className="flex flex-col flex-1 p-4">
            <h3 className="line-clamp-2 text-lg font-bold text-slate-900 group-hover:text-purple-600 transition-colors">
              {title}
            </h3>

            <p className="mt-2 line-clamp-2 text-sm text-slate-600">{excerpt}</p>

            {/* Tags */}
            {tags.length > 0 && (
              <div className="mt-3 flex flex-wrap gap-1">
                {tags.slice(0, 2).map((tag) => (
                  <Badge key={tag.slug} variant="secondary">
                    {tag.name}
                  </Badge>
                ))}
                {tags.length > 2 && <Badge variant="secondary">+{tags.length - 2}</Badge>}
              </div>
            )}

            {/* Footer */}
            <div className="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
              <div className="flex items-center gap-2">
                {author && <span>{author.name}</span>}
                {formattedDate && <span>•</span>}
                {formattedDate && <span>{formattedDate}</span>}
              </div>
              {views !== undefined && <span className="flex items-center gap-1">👁️ {views}</span>}
            </div>
          </div>
        </article>
      </Link>
    </motion.div>
  );
}
