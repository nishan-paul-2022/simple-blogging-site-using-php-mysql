const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

interface ApiResponse<T> {
  data?: T;
  message?: string;
  errors?: Record<string, string[]>;
  status?: string;
}

interface ApiRequestOptions extends RequestInit {
  headers?: Record<string, string>;
}

export async function apiCall<T = any>(
  endpoint: string,
  options: ApiRequestOptions = {}
): Promise<ApiResponse<T>> {
  const url = `${API_URL}${endpoint.startsWith('/') ? endpoint : `/${endpoint}`}`;

  const defaultHeaders: Record<string, string> = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  const token = typeof window !== 'undefined' ? localStorage.getItem('token') : null;
  if (token) {
    defaultHeaders['Authorization'] = `Bearer ${token}`;
  }

  const headers = {
    ...defaultHeaders,
    ...(options.headers || {}),
  };

  try {
    const response = await fetch(url, {
      ...options,
      headers,
    });

    const data: ApiResponse<T> = await response.json().catch(() => ({}));

    if (!response.ok) {
      throw new Error(data.message || `API error: ${response.status}`);
    }

    return data;
  } catch (error) {
    console.error(`API call failed: ${endpoint}`, error);
    throw error;
  }
}

export async function fetchPosts(page: number = 1) {
  return apiCall('/posts', {
    method: 'GET',
    headers: {
      'X-Page': page.toString(),
    },
  });
}

export async function fetchPost(id: string | number) {
  return apiCall(`/posts/${id}`, {
    method: 'GET',
  });
}

export async function createPost(data: any) {
  return apiCall('/posts', {
    method: 'POST',
    body: JSON.stringify(data),
  });
}

export async function updatePost(id: string | number, data: any) {
  return apiCall(`/posts/${id}`, {
    method: 'PUT',
    body: JSON.stringify(data),
  });
}

export async function deletePost(id: string | number) {
  return apiCall(`/posts/${id}`, {
    method: 'DELETE',
  });
}

export async function fetchCategories() {
  return apiCall('/categories', {
    method: 'GET',
  });
}

export async function fetchTags() {
  return apiCall('/tags', {
    method: 'GET',
  });
}

export async function login(email: string, password: string) {
  return apiCall('/auth/login', {
    method: 'POST',
    body: JSON.stringify({ email, password }),
  });
}

export async function register(data: any) {
  return apiCall('/auth/register', {
    method: 'POST',
    body: JSON.stringify(data),
  });
}

export async function logout() {
  if (typeof window !== 'undefined') {
    localStorage.removeItem('token');
  }
}
