'use client';

import { cva, type VariantProps } from 'class-variance-authority';
import clsx from 'clsx';
import React from 'react';

const badgeVariants = cva(
  'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium transition-colors',
  {
    variants: {
      variant: {
        primary: 'bg-purple-100 text-purple-700 hover:bg-purple-200',
        secondary: 'bg-slate-100 text-slate-700 hover:bg-slate-200',
        success: 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200',
        warning: 'bg-amber-100 text-amber-700 hover:bg-amber-200',
        destructive: 'bg-red-100 text-red-700 hover:bg-red-200',
      },
    },
    defaultVariants: {
      variant: 'primary',
    },
  }
);

interface BadgeProps
  extends React.HTMLAttributes<HTMLDivElement>,
    VariantProps<typeof badgeVariants> {}

const Badge = React.forwardRef<HTMLDivElement, BadgeProps>(
  ({ className, variant, ...props }, ref) => (
    <div
      ref={ref}
      className={clsx(badgeVariants({ variant, className }))}
      {...props}
    />
  )
);

Badge.displayName = 'Badge';

export { Badge, badgeVariants };
