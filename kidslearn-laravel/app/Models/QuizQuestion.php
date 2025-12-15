<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'image_path',
        'correct_answer',
        'options',
        'category',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Get random question by category
     */
    public static function getRandomByCategory(string $category)
    {
        return self::where('category', $category)->inRandomOrder()->first();
    }

    /**
     * Check if answer is correct
     */
    public function checkAnswer(string $answer): bool
    {
        return strtolower($answer) === strtolower($this->correct_answer);
    }
}
