<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question' => 'What mammals is this?',
                'image_path' => 'img/kucing.png',
                'correct_answer' => 'cat',
                'options' => json_encode(['cat', 'dog', 'cow', 'ant']),
                'category' => 'mammals'
            ],
            [
                'question' => 'What animal has a long trunk?',
                'image_path' => 'img/elephant.png',
                'correct_answer' => 'elephant',
                'options' => json_encode(['elephant', 'dog', 'cow', 'cat']),
                'category' => 'mammals'
            ],
            [
                'question' => 'Which bird can mimic human speech?',
                'image_path' => 'img/parrot.png',
                'correct_answer' => 'parrot',
                'options' => json_encode(['parrot', 'eagle', 'crow', 'sparrow']),
                'category' => 'birds'
            ],
            [
                'question' => 'What sea animal is very intelligent?',
                'image_path' => 'img/dolphin.png',
                'correct_answer' => 'dolphin',
                'options' => json_encode(['dolphin', 'shark', 'whale', 'octopus']),
                'category' => 'sea'
            ],
        ];

        foreach ($questions as $question) {
            QuizQuestion::create($question);
        }
    }
}
