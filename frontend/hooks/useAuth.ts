'use client';

import { useState, useCallback } from 'react';

export interface AuthUser {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  is_admin?: boolean;
}

export interface UseAuthReturn {
  user: AuthUser | null;
  token: string | null;
  loading: boolean;
  isAuthenticated: boolean;
  logout: () => void;
  setUser: (user: AuthUser | null) => void;
}

export function useAuth(): UseAuthReturn {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [token, setToken] = useState<string | null>(() => {
    if (typeof window === 'undefined') {
      return null;
    }

    return localStorage.getItem('authToken');
  });
  const loading = false;

  const logout = useCallback(() => {
    localStorage.removeItem('authToken');
    setToken(null);
    setUser(null);
  }, []);

  return {
    user,
    token,
    loading,
    isAuthenticated: !!token,
    logout,
    setUser,
  };
}
