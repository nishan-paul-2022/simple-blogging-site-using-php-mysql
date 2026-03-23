const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

export interface User {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  bio?: string;
  is_admin?: boolean;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  description?: string;
  color?: string;
}

export interface Tag {
  id: number;
  name: string;
  slug: string;
}

export interface Post {
  id: number;
  title: string;
  slug: string;
  content: string;
  excerpt?: string;
  featured_image?: string;
  status: 'draft' | 'published' | 'archived';
  views: number;
  user_id: number;
  category_id: number;
  user?: User;
  category?: Category;
  tags?: Tag[];
  comments_count?: number;
  created_at: string;
  updated_at: string;
}

export interface Comment {
  id: number;
  post_id: number;
  user_id: number;
  parent_id?: number;
  content: string;
  approved: boolean;
  user?: User;
  replies?: Comment[];
  created_at: string;
}

interface ApiResponse<T> {
  data?: T;
  access_token?: string;
  message?: string;
  errors?: Record<string, string[]>;
  status?: string;
}

interface ApiRequestOptions extends RequestInit {
  headers?: Record<string, string>;
}

export async function apiCall<T>(
  endpoint: string,
  options: ApiRequestOptions = {}
): Promise<ApiResponse<T>> {
  const url = `${API_URL}${endpoint.startsWith('/') ? endpoint : `/${endpoint}`}`;

  const defaultHeaders: Record<string, string> = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  };

  const token =
    typeof window !== 'undefined'
      ? localStorage.getItem('token') || localStorage.getItem('authToken')
      : null;
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
  return apiCall<Post[]>('/posts', {
    method: 'GET',
    headers: {
      'X-Page': page.toString(),
    },
  });
}

export async function fetchPost(id: string | number) {
  return apiCall<Post>(`/posts/${id}`, {
    method: 'GET',
  });
}

export async function createPost(data: Partial<Post>) {
  return apiCall<Post>('/posts', {
    method: 'POST',
    body: JSON.stringify(data),
  });
}

export async function updatePost(id: string | number, data: Partial<Post>) {
  return apiCall<Post>(`/posts/${id}`, {
    method: 'PUT',
    body: JSON.stringify(data),
  });
}

export async function deletePost(id: string | number) {
  return apiCall<void>(`/posts/${id}`, {
    method: 'DELETE',
  });
}

export async function fetchCategories() {
  return apiCall<Category[]>('/categories', {
    method: 'GET',
  });
}

export async function fetchTags() {
  return apiCall<Tag[]>('/tags', {
    method: 'GET',
  });
}

export async function login(email: string, password: string) {
  return apiCall<User>('/auth/login', {
    method: 'POST',
    body: JSON.stringify({ email, password }),
  });
}

export async function register(data: Partial<User> & { password?: string }) {
  return apiCall<User>('/auth/register', {
    method: 'POST',
    body: JSON.stringify(data),
  });
}

export async function logout() {
  if (typeof window !== 'undefined') {
    localStorage.removeItem('token');
    localStorage.removeItem('authToken');
  }
}
