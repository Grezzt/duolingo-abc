'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import Image from 'next/image';
import { authService } from '@/services/auth.service';

const AVATARS = [
  '/img/avatar1.png',
  '/img/avatar2.png',
  '/img/avatar3.png',
  '/img/avatar4.png',
  '/img/avatar5.png',
  '/img/avatar6.png',
];

export default function RegisterPage() {
  const router = useRouter();
  const [formData, setFormData] = useState({
    name: '',
    password: '',
    confirmPassword: '',
    avatar: '/img/avatar1.png',
  });
  const [message, setMessage] = useState({ text: '', type: '' });
  const [showAvatarPicker, setShowAvatarPicker] = useState(false);
  const [loading, setLoading] = useState(false);

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();
    setMessage({ text: '', type: '' });

    if (!formData.name || !formData.password || !formData.confirmPassword) {
      setMessage({ text: '✍️ Lengkapi semua data dulu ya!', type: 'error' });
      return;
    }

    if (formData.password !== formData.confirmPassword) {
      setMessage({ text: '❌ Kata sandi tidak sama', type: 'error' });
      return;
    }

    if (formData.password.length < 4) {
      setMessage({ text: '❌ Kata sandi minimal 4 karakter', type: 'error' });
      return;
    }

    setLoading(true);

    try {
      await authService.register({
        name: formData.name,
        password: formData.password,
        avatar: formData.avatar,
      });

      setMessage({ text: '🎉 Hore! Akun berhasil dibuat!', type: 'success' });

      setTimeout(() => {
        router.push('/login');
      }, 1200);
    } catch (error: any) {
      setMessage({ text: `❌ ${error.message}`, type: 'error' });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-purple-400 to-pink-300 bg-clouds relative overflow-hidden">
      {/* Cloud decorations */}
      <div className="absolute top-10 left-10 w-32 h-16 bg-white rounded-full opacity-80 blur-sm"></div>
      <div className="absolute top-20 right-20 w-40 h-20 bg-white rounded-full opacity-70 blur-sm"></div>

      <div className="min-h-screen flex items-center justify-center p-4">
        <div className="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md relative">
          {/* Mascot */}
          <div className="flex justify-center -mt-20 mb-4">
            <div className="bg-white rounded-full p-4 shadow-lg">
              <div className="text-8xl animate-wiggle">🎨</div>
            </div>
          </div>

          {/* Title */}
          <h1 className="text-3xl font-bold text-center mb-2 text-gray-800">
            🎉 Yuk Daftar!
          </h1>
          <p className="text-center text-gray-600 mb-6">
            Buat akun seru kamu ✨
          </p>

          {/* Avatar Selection */}
          <div className="mb-6">
            <div className="flex justify-center mb-2">
              <div className="relative w-24 h-24 rounded-full overflow-hidden border-4 border-blue-500 shadow-lg">
                <div className="w-full h-full bg-gray-200 flex items-center justify-center text-6xl">
                  {formData.avatar ? '👤' : '❓'}
                </div>
              </div>
            </div>
            <div className="text-center">
              <button
                type="button"
                onClick={() => setShowAvatarPicker(true)}
                className="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition"
              >
                🎨 Ganti Avatar
              </button>
            </div>
          </div>

          {/* Form */}
          <form onSubmit={handleRegister} className="space-y-4">
            <input
              type="text"
              placeholder="🧒 Nama Kamu"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
              className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition text-gray-800"
              disabled={loading}
            />

            <input
              type="password"
              placeholder="🔒 Kata Sandi"
              value={formData.password}
              onChange={(e) => setFormData({ ...formData, password: e.target.value })}
              className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition text-gray-800"
              disabled={loading}
            />

            <input
              type="password"
              placeholder="🔁 Ulangi Kata Sandi"
              value={formData.confirmPassword}
              onChange={(e) =>
                setFormData({ ...formData, confirmPassword: e.target.value })
              }
              className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition text-gray-800"
              disabled={loading}
            />

            <button
              type="submit"
              disabled={loading}
              className="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-3 rounded-xl font-bold text-lg hover:from-purple-600 hover:to-pink-600 transform hover:scale-105 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {loading ? '⏳ Memproses...' : '✅ Daftar'}
            </button>
          </form>

          {/* Message */}
          {message.text && (
            <div
              className={`mt-4 p-3 rounded-lg text-center ${
                message.type === 'success'
                  ? 'bg-green-100 text-green-700'
                  : 'bg-red-100 text-red-700'
              }`}
            >
              {message.text}
            </div>
          )}

          {/* Login Link */}
          <div className="mt-6 text-center">
            <Link
              href="/login"
              className="text-purple-600 hover:text-purple-700 font-medium hover:underline"
            >
              ⬅️ Kembali ke Login
            </Link>
          </div>
        </div>
      </div>

      {/* Avatar Picker Modal */}
      {showAvatarPicker && (
        <div
          className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
          onClick={() => setShowAvatarPicker(false)}
        >
          <div
            className="bg-white rounded-2xl p-6 max-w-md w-full"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-xl font-bold text-gray-800">🎨 Pilih Avatar</h3>
              <button
                onClick={() => setShowAvatarPicker(false)}
                className="text-gray-500 hover:text-gray-700 text-2xl"
              >
                ✖
              </button>
            </div>

            <div className="grid grid-cols-3 gap-4">
              {AVATARS.map((avatar, index) => (
                <button
                  key={index}
                  onClick={() => {
                    setFormData({ ...formData, avatar });
                    setShowAvatarPicker(false);
                  }}
                  className={`p-2 rounded-xl border-4 transition ${
                    formData.avatar === avatar
                      ? 'border-purple-500 bg-purple-50'
                      : 'border-gray-200 hover:border-purple-300'
                  }`}
                >
                  <div className="w-full aspect-square bg-gray-200 rounded-lg flex items-center justify-center text-4xl">
                    👤
                  </div>
                </button>
              ))}
            </div>
          </div>
        </div>
      )}

      {/* Footer */}
      <footer className="absolute bottom-4 w-full text-center text-white text-sm">
        KidsLearn © 2025 — Belajar Dengan Senang!
      </footer>
    </div>
  );
}
