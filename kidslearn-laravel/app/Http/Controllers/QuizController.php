<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\User;

class QuizController extends Controller
{
    /**
     * Show quiz game
     */
    public function index(Request $request)
    {
        $category = $request->get('category', 'mammals');
        $question = QuizQuestion::getRandomByCategory($category);

        if (!$question) {
            return redirect()->route('dashboard')
                ->with('error', 'Tidak ada pertanyaan untuk kategori ini');
        }

        return view('quiz.index', compact('question', 'category'));
    }

    /**
     * Check quiz answer
     */
    public function checkAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
            'answer' => 'required',
        ]);

        $question = QuizQuestion::findOrFail($request->question_id);
        $isCorrect = $question->checkAnswer($request->answer);

        /** @var User $user */
        $user = Auth::user();
        $progress = $user->getOrCreateProgress();
        $progress->incrementQuizCompleted($isCorrect);

        if ($isCorrect) {
            return response()->json([
                'success' => true,
                'result' => 'correct',
                'message' => "🎉 Jawaban kamu BENAR! Ini adalah hewan {$question->category} yaitu " . strtoupper($question->correct_answer) . ".",
                'xp_gained' => 10
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => 'wrong',
            'message' => "❌ Jawaban kamu kurang tepat. Coba lagi ya! Jawaban yang benar adalah " . strtoupper($question->correct_answer) . "."
        ]);
    }
}
