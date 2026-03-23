'use client';

import { useState, useCallback } from 'react';

export function useApi<T = any>(
  apiCall: (...args: any[]) => Promise<T>
) {
  const [data, setData] = useState<T | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<Error | null>(null);

  const execute = useCallback(
    async (...args: any[]) => {
      try {
        setLoading(true);
        setError(null);
        const result = await apiCall(...args);
        setData(result);
        return result;
      } catch (err) {
        const error = err instanceof Error ? err : new Error(String(err));
        setError(error);
        throw error;
      } finally {
        setLoading(false);
      }
    },
    [apiCall]
  );

  return { data, loading, error, execute };
}

export function useApiWithQuery(
  queryKey: string[],
  queryFn: () => Promise<any>,
  options: any = {}
) {
  const [data, setData] = useState<any>(null);
  const [isLoading, setIsLoading] = useState(false);
  const [isError, setIsError] = useState(false);
  const [error, setError] = useState<Error | null>(null);

  const refetch = useCallback(async () => {
    try {
      setIsLoading(true);
      setIsError(false);
      setError(null);
      const result = await queryFn();
      setData(result);
      return result;
    } catch (err) {
      const error = err instanceof Error ? err : new Error(String(err));
      setError(error);
      setIsError(true);
      throw error;
    } finally {
      setIsLoading(false);
    }
  }, [queryFn]);

  return {
    data,
    isLoading,
    isError,
    error,
    refetch,
  };
}
