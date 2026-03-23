'use client';

import { cva, type VariantProps } from 'class-variance-authority';
import clsx from 'clsx';
import React from 'react';

const buttonVariants = cva(
  'inline-flex items-center justify-center rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed',
  {
    variants: {
      variant: {
        primary:
          'bg-gradient-to-r from-purple-600 to-emerald-600 text-white hover:shadow-lg hover:shadow-purple-500/30',
        secondary: 'bg-slate-100 text-slate-900 hover:bg-slate-200',
        outline: 'border-2 border-purple-600 text-purple-600 hover:bg-purple-50',
        ghost: 'text-slate-600 hover:bg-slate-100',
      },
      size: {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-base',
        lg: 'px-6 py-3 text-lg',
      },
      fullWidth: {
        true: 'w-full',
        false: '',
      },
    },
    defaultVariants: {
      variant: 'primary',
      size: 'md',
      fullWidth: false,
    },
  }
);

interface ButtonProps
  extends React.ButtonHTMLAttributes<HTMLButtonElement>, VariantProps<typeof buttonVariants> {
  asChild?: boolean;
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant, size, fullWidth, asChild = false, children, ...props }, ref) => {
    if (asChild && React.isValidElement(children)) {
      return React.cloneElement(
        children as React.ReactElement,
        {
          ...props,
          className: clsx(
            buttonVariants({ variant, size, fullWidth, className }),
            (children.props as any).className
          ),
        } as any
      );
    }

    return (
      <button
        className={clsx(buttonVariants({ variant, size, fullWidth, className }))}
        ref={ref}
        {...props}
      >
        {children}
      </button>
    );
  }
);

Button.displayName = 'Button';

export { Button, buttonVariants };
