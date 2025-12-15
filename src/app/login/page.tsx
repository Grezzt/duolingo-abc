'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import Image from 'next/image';
import { authService } from '@/services/auth.service';
import { useUserStore } from '@/store/userStore';

export default function LoginPage() {
  const router = useRouter();
  const setUser = useUserStore((state) => state.setUser);
  const [formData, setFormData] = useState({
    name: '',
    password: '',
  });
  const [message, setMessage] = useState({ text: '', type: '' });
  const [shake, setShake] = useState(false);
  const [loading, setLoading] = useState(false);

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setMessage({ text: '', type: '' });

    if (!formData.name || !formData.password) {
      setMessage({ text: '✍️ Isi nama dan kata sandi dulu ya!', type: 'error' });
      setShake(true);
      setTimeout(() => setShake(false), 400);
      return;
    }

    setLoading(true);

    try {
      const user = await authService.login(formData);
      setUser(user);
      setMessage({ text: `🎉 Hore! Selamat datang ${user.name}!`, type: 'success' });

      setTimeout(() => {
        router.push('/dashboard');
      }, 1000);
    } catch (error: any) {
      setMessage({ text: `❌ ${error.message}`, type: 'error' });
      setShake(true);
      setTimeout(() => setShake(false), 400);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-sky-400 to-blue-300 bg-clouds relative overflow-hidden">
      {/* Cloud decorations */}
      <div className="absolute top-10 left-10 w-32 h-16 bg-white rounded-full opacity-80 blur-sm"></div>
      <div className="absolute top-20 right-20 w-40 h-20 bg-white rounded-full opacity-70 blur-sm"></div>
      <div className="absolute bottom-20 left-1/4 w-36 h-18 bg-white rounded-full opacity-75 blur-sm"></div>

      <div className="min-h-screen flex items-center justify-center p-4">
        <div
          className={`bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md relative ${
            shake ? 'animate-shake' : ''
          }`}
        >
          {/* Mascot */}
          <div className="flex justify-center -mt-20 mb-4">
            <div className="bg-white rounded-full p-4 shadow-lg">
              <div className="text-8xl animate-wiggle">🦁</div>
            </div>
          </div>

          {/* Message */}
          {message.text && (
            <div
              className={`mb-4 p-3 rounded-lg text-center ${
                message.type === 'success'
                  ? 'bg-green-100 text-green-700'
                  : 'bg-red-100 text-red-700'
              }`}
            >
              {message.text}
            </div>
          )}

          {/* Title */}
          <h1 className="text-3xl font-bold text-center mb-2 text-gray-800">
            👋 Halo Teman!
          </h1>
          <p className="text-center text-gray-600 mb-6">
            Yuk masuk ke dunia belajar 🚀
          </p>

          {/* Form */}
          <form onSubmit={handleLogin} className="space-y-4">
            <input
              type="text"
              placeholder="🧒 Nama Kamu"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
              className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none transition text-gray-800"
              disabled={loading}
            />

            <input
              type="password"
              placeholder="🔒 Kata Sandi"
              value={formData.password}
              onChange={(e) => setFormData({ ...formData, password: e.target.value })}
              className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none transition text-gray-800"
              disabled={loading}
            />

            <button
              type="submit"
              disabled={loading}
              className="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl font-bold text-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {loading ? '⏳ Memproses...' : '🚀 Masuk'}
            </button>
          </form>

          {/* Register Link */}
          <div className="mt-6 text-center">
            <Link
              href="/register"
              className="text-blue-600 hover:text-blue-700 font-medium hover:underline"
            >
              📝 Daftar di sini
            </Link>
          </div>
        </div>
      </div>

      {/* Footer */}
      <footer className="absolute bottom-4 w-full text-center text-white text-sm">
        KidsLearn © 2025 — Belajar Dengan Senang!
      </footer>
    </div>
  );
}
