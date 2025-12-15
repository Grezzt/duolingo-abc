'use client';

import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { useUserStore } from '@/store/userStore';
import { animalService, type Animal } from '@/services/data.service';

export default function MammalsPage() {
  const router = useRouter();
  const user = useUserStore((state) => state.user);
  const [animals, setAnimals] = useState<Animal[]>([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [loading, setLoading] = useState(true);
  const [audio, setAudio] = useState<HTMLAudioElement | null>(null);

  useEffect(() => {
    if (!user) {
      router.push('/login');
      return;
    }

    loadAnimals();
  }, [user, router]);

  const loadAnimals = async () => {
    try {
      const data = await animalService.getAnimalsByCategory('mammals');
      setAnimals(data);
    } catch (error) {
      console.error('Error loading animals:', error);
    } finally {
      setLoading(false);
    }
  };

  const currentAnimal = animals[currentIndex];

  const nextAnimal = () => {
    setCurrentIndex((prev) => (prev + 1) % animals.length);
  };

  const prevAnimal = () => {
    setCurrentIndex((prev) => (prev - 1 + animals.length) % animals.length);
  };

  const playSound = () => {
    if (!currentAnimal) return;

    if (audio) {
      audio.pause();
    }

    const newAudio = new Audio(currentAnimal.sound_url);
    newAudio.play().catch((err) => {
      console.error('Error playing sound:', err);
      alert('Sound file not available');
    });
    setAudio(newAudio);
  };

  if (!user) return null;

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 mx-auto"></div>
          <p className="mt-4 text-gray-600">Loading...</p>
        </div>
      </div>
    );
  }

  if (animals.length === 0) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="text-6xl mb-4">😢</div>
          <p className="text-xl text-gray-600">No animals found</p>
          <p className="text-gray-500 mt-2">Please seed the database first</p>
          <Link href="/learning">
            <button className="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
              Back to Learning
            </button>
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-amber-100 to-orange-100">
      {/* Header */}
      <header className="bg-white shadow-md">
        <div className="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
          <Link href="/learning">
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

          <div className="text-center">
            <h1 className="text-xl font-bold text-gray-800">
              Learning - Animals Mammals
            </h1>
            <p className="text-sm text-gray-600">Let's learn about animals</p>
          </div>

          <div className="w-10 h-10"></div>
        </div>
      </header>

      {/* Main Content */}
      <div className="max-w-4xl mx-auto px-4 py-8">
        {/* Mascot */}
        <div className="flex justify-center mb-8">
          <div className="text-7xl animate-bounce-slow">🦁</div>
        </div>

        {/* Animal Card */}
        <div className="bg-white rounded-3xl shadow-2xl overflow-hidden mb-8 relative">
          <div className="h-64 bg-gradient-to-b from-green-300 to-green-500 relative overflow-hidden">
            {/* Background decoration */}
            <div className="absolute inset-0 opacity-20">
              <div className="absolute bottom-0 left-0 w-32 h-32 bg-green-700 rounded-full -mb-16 -ml-16"></div>
              <div className="absolute top-0 right-0 w-24 h-24 bg-green-700 rounded-full -mt-12 -mr-12"></div>
            </div>

            {/* Animal placeholder - replace with actual image when available */}
            <div className="absolute inset-0 flex items-center justify-center">
              <div className="text-9xl animate-bounce-slow">
                {currentAnimal.name === 'Dog' && '🐕'}
                {currentAnimal.name === 'Elephant' && '🐘'}
                {currentAnimal.name === 'Cat' && '🐱'}
                {currentAnimal.name === 'Cow' && '🐄'}
                {currentAnimal.name === 'Horse' && '🐴'}
                {!['Dog', 'Elephant', 'Cat', 'Cow', 'Horse'].includes(
                  currentAnimal.name
                ) && '🦁'}
              </div>
            </div>
          </div>
        </div>

        {/* Controls */}
        <div className="flex items-center justify-center gap-6 mb-6">
          <button
            onClick={prevAnimal}
            className="w-14 h-14 rounded-full bg-blue-500 text-white text-2xl hover:bg-blue-600 transition shadow-lg flex items-center justify-center"
          >
            ⬅
          </button>

          <button
            onClick={playSound}
            className="w-16 h-16 rounded-full bg-green-500 text-white text-3xl hover:bg-green-600 transition shadow-lg flex items-center justify-center"
          >
            🔊
          </button>

          <div className="text-center">
            <h3 className="text-3xl font-bold text-gray-800">{currentAnimal.name}</h3>
            <p className="text-sm text-gray-500">
              {currentIndex + 1} / {animals.length}
            </p>
          </div>

          <button
            onClick={nextAnimal}
            className="w-14 h-14 rounded-full bg-blue-500 text-white text-2xl hover:bg-blue-600 transition shadow-lg flex items-center justify-center"
          >
            ➡
          </button>
        </div>

        {/* Description */}
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-6">
          <h4 className="text-xl font-bold text-gray-800 mb-3">Description</h4>
          <p className="text-gray-700 leading-relaxed">{currentAnimal.description}</p>
        </div>

        {/* Fun Facts */}
        {currentAnimal.fun_facts && currentAnimal.fun_facts.length > 0 && (
          <div className="bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl shadow-lg p-6">
            <h4 className="text-xl font-bold text-gray-800 mb-3">🎉 Fun Facts</h4>
            <ul className="space-y-2">
              {currentAnimal.fun_facts.map((fact, index) => (
                <li key={index} className="flex items-start gap-2">
                  <span className="text-purple-600 font-bold">•</span>
                  <span className="text-gray-700">{fact}</span>
                </li>
              ))}
            </ul>
          </div>
        )}
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
