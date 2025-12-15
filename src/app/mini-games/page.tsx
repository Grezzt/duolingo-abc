'use client';

import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { useUserStore } from '@/store/userStore';
import { quizService, type QuizQuestion } from '@/services/data.service';

export default function MiniGamesPage() {
  const router = useRouter();
  const user = useUserStore((state) => state.user);
  const updateExperience = useUserStore((state) => state.updateExperience);
  const [quiz, setQuiz] = useState<QuizQuestion | null>(null);
  const [selectedAnswer, setSelectedAnswer] = useState<string>('');
  const [result, setResult] = useState<{ type: string; message: string } | null>(null);
  const [loading, setLoading] = useState(true);
  const [hasAnswered, setHasAnswered] = useState(false);

  useEffect(() => {
    if (!user) {
      router.push('/login');
      return;
    }

    loadQuiz();
  }, [user, router]);

  const loadQuiz = async () => {
    try {
      const quizData = await quizService.getRandomQuiz('mammals');
      setQuiz(quizData);
      setSelectedAnswer('');
      setResult(null);
      setHasAnswered(false);
    } catch (error) {
      console.error('Error loading quiz:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = () => {
    if (!selectedAnswer || !quiz) {
      alert('Pilih jawaban terlebih dahulu!');
      return;
    }

    setHasAnswered(true);

    if (selectedAnswer === quiz.correct_answer) {
      setResult({
        type: 'correct',
        message: `🎉 Jawaban kamu BENAR! Ini adalah hewan mamalia yaitu ${quiz.correct_answer.toUpperCase()}.`,
      });
      // Award experience points
      updateExperience(10);
    } else {
      setResult({
        type: 'wrong',
        message: '❌ Jawaban kamu kurang tepat. Coba lagi ya!',
      });
    }
  };

  const handleNextQuiz = () => {
    loadQuiz();
  };

  if (!user) return null;

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-16 w-16 border-t-4 border-purple-500 mx-auto"></div>
          <p className="mt-4 text-gray-600">Loading quiz...</p>
        </div>
      </div>
    );
  }

  if (!quiz) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gradient-to-b from-purple-100 to-pink-100">
        <div className="text-center">
          <div className="text-6xl mb-4">😢</div>
          <p className="text-xl text-gray-600 mb-2">No quiz available</p>
          <p className="text-gray-500 mb-4">Please seed the database first</p>
          <Link href="/dashboard">
            <button className="px-6 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
              Back to Dashboard
            </button>
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-purple-100 to-pink-100">
      {/* Header */}
      <header className="bg-white shadow-md">
        <div className="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
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

          <div className="text-center">
            <h1 className="text-xl font-bold text-gray-800">
              Mini Games – Guess the Animal
            </h1>
            <p className="text-sm text-gray-600">Let's learn about animals</p>
          </div>

          <div className="text-4xl animate-wiggle">🎨</div>
        </div>
      </header>

      {/* Main Content */}
      <div className="max-w-2xl mx-auto px-4 py-8">
        {/* Game Box */}
        <div className="bg-white rounded-3xl shadow-2xl p-8 mb-8">
          <div className="flex justify-center mb-6">
            <div className="w-64 h-64 bg-gradient-to-b from-green-200 to-green-400 rounded-2xl flex items-center justify-center shadow-lg">
              {/* Animal emoji placeholder */}
              <div className="text-9xl">
                {quiz.correct_answer === 'cat' && '🐱'}
                {quiz.correct_answer === 'dog' && '🐕'}
                {quiz.correct_answer === 'elephant' && '🐘'}
                {quiz.correct_answer === 'cow' && '🐄'}
                {!['cat', 'dog', 'elephant', 'cow'].includes(quiz.correct_answer) &&
                  '❓'}
              </div>
            </div>
          </div>

          {/* Question */}
          <h3 className="text-2xl font-bold text-center text-gray-800 mb-8">
            {quiz.question}
          </h3>

          {/* Answers */}
          <div className="grid grid-cols-2 gap-4 mb-6">
            {quiz.options.map((option) => (
              <label
                key={option}
                className={`cursor-pointer ${hasAnswered ? 'cursor-not-allowed' : ''}`}
              >
                <input
                  type="radio"
                  name="answer"
                  value={option}
                  checked={selectedAnswer === option}
                  onChange={(e) => !hasAnswered && setSelectedAnswer(e.target.value)}
                  disabled={hasAnswered}
                  className="hidden peer"
                />
                <div className="p-4 border-4 border-gray-300 rounded-xl text-center font-bold text-lg uppercase transition peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-purple-300">
                  {option}
                </div>
              </label>
            ))}
          </div>

          {/* Submit Button */}
          {!hasAnswered ? (
            <button
              onClick={handleSubmit}
              className="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-4 rounded-xl font-bold text-xl hover:from-purple-600 hover:to-pink-600 transform hover:scale-105 transition shadow-lg"
            >
              PERIKSA
            </button>
          ) : (
            <button
              onClick={handleNextQuiz}
              className="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white py-4 rounded-xl font-bold text-xl hover:from-green-600 hover:to-blue-600 transform hover:scale-105 transition shadow-lg"
            >
              PERTANYAAN BERIKUTNYA ➡
            </button>
          )}
        </div>

        {/* Result */}
        {result && (
          <div
            className={`rounded-2xl shadow-lg p-6 text-center text-lg font-medium ${
              result.type === 'correct'
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700'
            }`}
          >
            {result.message}
            {result.type === 'correct' && (
              <div className="mt-2 text-sm">+10 XP earned! 🎉</div>
            )}
          </div>
        )}

        {/* Stats */}
        <div className="mt-8 bg-white rounded-2xl shadow-lg p-6">
          <h4 className="text-lg font-bold text-gray-800 mb-2">Your Progress</h4>
          <div className="flex justify-between items-center">
            <span className="text-gray-600">Level:</span>
            <span className="font-bold text-blue-600">{user.level}</span>
          </div>
          <div className="flex justify-between items-center mt-2">
            <span className="text-gray-600">Experience:</span>
            <span className="font-bold text-green-600">{user.experience} XP</span>
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
