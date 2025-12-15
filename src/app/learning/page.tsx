'use client';

import { useEffect } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { useUserStore } from '@/store/userStore';

const CATEGORIES = [
  { id: 'mammals', name: 'Mammals', icon: '🐘', link: '/learning/mammals' },
  { id: 'birds', name: 'Birds', icon: '🦜', link: '/learning/birds' },
  { id: 'sea', name: 'Sea Animals', icon: '🐬', link: '/learning/sea' },
  { id: 'insects', name: 'Insects', icon: '🦋', link: '/learning/insects' },
  { id: 'reptiles', name: 'Reptiles', icon: '🐍', link: '/learning/reptiles' },
  { id: 'amphibians', name: 'Amphibians', icon: '🐸', link: '/learning/amphibians' },
];

export default function LearningPage() {
  const router = useRouter();
  const user = useUserStore((state) => state.user);

  useEffect(() => {
    if (!user) {
      router.push('/login');
    }
  }, [user, router]);

  if (!user) return null;

  return (
    <div className="min-h-screen bg-gradient-to-b from-green-100 to-blue-100">
      {/* Header */}
      <header className="bg-white shadow-md">
        <div className="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
          <div className="flex items-center gap-4">
            <Link href="/dashboard">
              <button className="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <path d="M15 18L9 12L15 6" />
                </svg>
              </button>
            </Link>
            <h1 className="text-2xl font-bold text-gray-800">Learning</h1>
          </div>

          <div className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xl border-2 border-blue-500">
            👤
          </div>
        </div>
      </header>

      {/* Main Content */}
      <div className="max-w-6xl mx-auto px-4 py-8">
        {/* Greeting */}
        <div className="text-center mb-8">
          <h2 className="text-3xl font-bold text-gray-800 mb-2">
            Hello, {user.name}! 👋
          </h2>
          <h3 className="text-xl text-gray-600">
            Let's learning with <br /> Me
          </h3>
        </div>

        <div className="grid md:grid-cols-2 gap-8 items-center">
          {/* Mascot */}
          <div className="flex justify-center">
            <div className="text-9xl animate-float">🦁</div>
          </div>

          {/* Categories */}
          <div>
            <div className="mb-6 text-center md:text-left">
              <div className="text-6xl mb-4">🌳</div>
              <h3 className="text-2xl font-bold text-gray-800 mb-2">
                Pilih Kategori Hewan
              </h3>
              <p className="text-gray-600">Belajar tentang berbagai jenis hewan</p>
            </div>

            <div className="grid grid-cols-2 gap-4">
              {CATEGORIES.map((category) => (
                <Link key={category.id} href={category.link}>
                  <div className="bg-white rounded-2xl p-6 text-center hover:scale-105 transform transition cursor-pointer shadow-lg hover:shadow-xl border-2 border-transparent hover:border-blue-400">
                    <div className="text-5xl mb-3">{category.icon}</div>
                    <h4 className="font-bold text-gray-800">{category.name}</h4>
                  </div>
                </Link>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Footer */}
      <footer className="mt-16 py-6 bg-white shadow-inner">
        <div className="max-w-6xl mx-auto text-center">
          <p className="text-gray-700 font-medium">
            KidsLearn © 2025 — Belajar Dengan Senang!
          </p>
        </div>
      </footer>
    </div>
  );
}
