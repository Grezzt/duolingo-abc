'use client';

import { useEffect } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { useUserStore } from '@/store/userStore';

export default function DashboardPage() {
  const router = useRouter();
  const user = useUserStore((state) => state.user);
  const logout = useUserStore((state) => state.logout);

  useEffect(() => {
    if (!user) {
      router.push('/login');
    }
  }, [user, router]);

  if (!user) return null;

  const levelProgress = (user.experience % 100) / 100;

  return (
    <div className="min-h-screen bg-gradient-to-b from-blue-100 to-green-100">
      {/* Navbar */}
      <nav className="bg-white shadow-md">
        <div className="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
          <div className="text-2xl font-bold text-blue-600">KidsLearn</div>

          <div className="flex items-center gap-4">
            {/* Avatar */}
            <div className="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-2xl border-2 border-blue-500 shadow">
              👤
            </div>
            <button
              onClick={() => {
                logout();
                router.push('/login');
              }}
              className="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
            >
              Keluar
            </button>
          </div>
        </div>
      </nav>

      {/* Level Progress */}
      <div className="max-w-6xl mx-auto px-4 py-6">
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-6">
          <div className="flex items-center justify-between mb-2">
            <span className="text-sm font-semibold text-gray-600">Level {user.level}</span>
            <span className="text-sm text-gray-500">{user.experience % 100}/100 XP</span>
          </div>
          <div className="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div
              className="bg-gradient-to-r from-green-400 to-blue-500 h-full rounded-full transition-all duration-500"
              style={{ width: `${levelProgress * 100}%` }}
            ></div>
          </div>
        </div>

        {/* Hero Section */}
        <div className="text-center mb-8">
          <h2 className="text-4xl font-bold text-gray-800 mb-2">
            Hello, {user.name}! 👋
          </h2>
          <h3 className="text-xl text-gray-600">Let's learning with Me</h3>
        </div>

        {/* Mascot */}
        <div className="flex justify-center mb-8">
          <div className="text-9xl animate-bounce-slow">🦁</div>
        </div>

        {/* Menu Boxes */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
          <Link href="/learning">
            <div className="bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl p-8 text-center hover:scale-105 transform transition cursor-pointer shadow-xl hover:shadow-2xl">
              <div className="text-6xl mb-4">📚</div>
              <h3 className="text-2xl font-bold text-white">Learning</h3>
              <p className="text-blue-100 mt-2">Belajar tentang hewan</p>
            </div>
          </Link>

          <Link href="/mini-games">
            <div className="bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl p-8 text-center hover:scale-105 transform transition cursor-pointer shadow-xl hover:shadow-2xl">
              <div className="text-6xl mb-4">🎮</div>
              <h3 className="text-2xl font-bold text-white">Mini Games</h3>
              <p className="text-purple-100 mt-2">Main sambil belajar</p>
            </div>
          </Link>

          <div className="bg-gradient-to-br from-green-400 to-green-600 rounded-2xl p-8 text-center opacity-50 cursor-not-allowed shadow-xl">
            <div className="text-6xl mb-4">📝</div>
            <h3 className="text-2xl font-bold text-white">Quiz</h3>
            <p className="text-green-100 mt-2">Segera hadir!</p>
          </div>
        </div>
      </div>

      {/* Footer */}
      <footer className="mt-16 py-6 bg-white shadow-inner">
        <div className="max-w-6xl mx-auto text-center">
          <p className="text-gray-700 font-medium mb-2">
            KidsLearn © 2025 — Belajar Dengan Senang!
          </p>
          <div className="flex justify-center gap-4 text-2xl">
            <span>📷</span>
            <span>🐦</span>
            <span>👍</span>
          </div>
        </div>
      </footer>
    </div>
  );
}
