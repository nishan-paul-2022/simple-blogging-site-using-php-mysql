'use client';

import { useEffect, useState, FormEvent } from 'react';
import { useRouter } from 'next/navigation';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/Button';
import { Card } from '@/components/ui/Card';

interface UserProfile {
  id: number;
  name: string;
  email: string;
  bio?: string;
  avatar?: string;
  is_admin: boolean;
  created_at: string;
  updated_at: string;
}

export default function ProfilePage() {
  const router = useRouter();
  const [user, setUser] = useState<UserProfile | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [editing, setEditing] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    bio: '',
  });

  useEffect(() => {
    const token = localStorage.getItem('authToken');
    if (!token) {
      router.push('/auth/login');
      return;
    }

    // Fetch user profile
    fetchUserProfile(token);
  }, [router]);

  const fetchUserProfile = async (token: string) => {
    try {
      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/me`, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json',
        },
      });

      if (!res.ok) {
        throw new Error('Failed to fetch profile');
      }

      const data = await res.json();
      setUser(data.data);
      setFormData({
        name: data.data.name,
        bio: data.data.bio || '',
      });
    } catch (err) {
      setError('Unable to load profile');
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    const token = localStorage.getItem('authToken');
    if (!token) return;

    try {
      const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/profile`, {
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (!res.ok) {
        throw new Error('Failed to update profile');
      }

      const data = await res.json();
      setUser(data.data);
      setEditing(false);
    } catch (err) {
      setError('Failed to update profile');
    }
  };

  const handleLogout = () => {
    localStorage.removeItem('authToken');
    router.push('/');
  };

  if (loading) {
    return (
      <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12">
        <div className="max-w-2xl mx-auto px-4">
          <div className="text-center">
            <div className="inline-block animate-pulse">
              <div className="w-16 h-16 bg-slate-300 rounded-full"></div>
            </div>
            <p className="mt-4 text-gray-600">Loading profile...</p>
          </div>
        </div>
      </main>
    );
  }

  return (
    <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12">
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="max-w-2xl mx-auto px-4"
      >
        {/* Page Header */}
        <div className="mb-8">
          <h1 className="text-4xl font-bold text-gray-900 mb-2">Profile</h1>
          <p className="text-gray-600">
            Manage your account information and settings
          </p>
        </div>

        {error && (
          <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {error}
          </div>
        )}

        {/* Profile Card */}
        <Card className="mb-6">
          <Card.Header>
            <Card.Title>Account Information</Card.Title>
            <Card.Description>
              {user?.is_admin ? '✨ Admin Account' : 'Regular Account'}
            </Card.Description>
          </Card.Header>

          <Card.Content className="space-y-6">
            {/* Avatar */}
            <div className="flex items-center gap-4">
              <div className="w-16 h-16 bg-gradient-to-r from-purple-500 to-emerald-500 rounded-full flex items-center justify-center text-white text-2xl">
                {user?.name.charAt(0) || 'U'}
              </div>
              <div>
                <p className="text-sm text-gray-600">Profile Picture</p>
                <p className="text-gray-900 font-semibold">{user?.name}</p>
              </div>
            </div>

            {/* Email (read-only) */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Email Address
              </label>
              <input
                type="email"
                value={user?.email || ''}
                disabled
                className="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
              />
            </div>

            {/* Member Since */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Member Since
              </label>
              <p className="text-gray-700">
                {user?.created_at ? new Date(user.created_at).toLocaleDateString() : 'N/A'}
              </p>
            </div>

            {/* Edit Section */}
            {editing ? (
              <>
                {/* Name Field */}
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Full Name
                  </label>
                  <input
                    type="text"
                    name="name"
                    value={formData.name}
                    onChange={handleChange}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>

                {/* Bio Field */}
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Bio
                  </label>
                  <textarea
                    name="bio"
                    value={formData.bio}
                    onChange={handleChange}
                    rows={4}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Tell us about yourself..."
                  />
                </div>

                {/* Action Buttons */}
                <div className="flex gap-3">
                  <Button
                    variant="primary"
                    onClick={handleSubmit}
                    className="flex-1"
                  >
                    Save Changes
                  </Button>
                  <Button
                    variant="secondary"
                    onClick={() => setEditing(false)}
                    className="flex-1"
                  >
                    Cancel
                  </Button>
                </div>
              </>
            ) : (
              <>
                {/* Bio Display */}
                {user?.bio && (
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Bio
                    </label>
                    <p className="text-gray-700">{user.bio}</p>
                  </div>
                )}

                {/* Edit Button */}
                <Button
                  variant="outline"
                  onClick={() => setEditing(true)}
                  className="w-full"
                >
                  Edit Profile
                </Button>
              </>
            )}
          </Card.Content>
        </Card>

        {/* Danger Zone */}
        <Card className="border-red-200 bg-red-50">
          <Card.Header>
            <Card.Title className="text-red-700">Danger Zone</Card.Title>
            <Card.Description>
              Irreversible actions
            </Card.Description>
          </Card.Header>

          <Card.Content className="space-y-4">
            <p className="text-sm text-gray-700">
              Logging out will clear your session. You'll need to sign in again to access your account.
            </p>
            <Button
              variant="ghost"
              onClick={handleLogout}
              className="w-full text-red-600 hover:text-red-700 hover:bg-red-100"
            >
              Sign Out
            </Button>
          </Card.Content>
        </Card>

        {/* Back Button */}
        <div className="mt-6 text-center">
          <a href="/" className="text-indigo-600 hover:text-indigo-700 transition">
            ← Back to home
          </a>
        </div>
      </motion.div>
    </main>
  );
}
