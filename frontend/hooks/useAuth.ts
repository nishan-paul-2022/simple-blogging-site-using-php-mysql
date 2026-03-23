'use client';

import { useState, useEffect, useCallback } from 'react';

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
  const [token, setToken] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);

  // Load auth from localStorage on mount
  useEffect(() => {
    const storedToken = localStorage.getItem('authToken');
    if (storedToken) {
      setToken(storedToken);
      // Optionally fetch user data from /auth/me endpoint
    }
    setLoading(false);
  }, []);

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
