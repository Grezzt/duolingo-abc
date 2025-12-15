<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
        'xp',
        'total_quizzes_completed',
        'correct_answers',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Add XP and update level
     */
    public function addXp(int $xp): void
    {
        $this->xp += $xp;

        // Level up every 100 XP
        $newLevel = floor($this->xp / 100) + 1;
        if ($newLevel > $this->level) {
            $this->level = $newLevel;
        }

        $this->save();
    }

    /**
     * Increment quiz completion
     */
    public function incrementQuizCompleted(bool $isCorrect): void
    {
        $this->total_quizzes_completed++;

        if ($isCorrect) {
            $this->correct_answers++;
            $this->addXp(10); // Add 10 XP for correct answer
        }

        $this->save();
    }

    /**
     * Calculate accuracy percentage
     */
    public function getAccuracy(): float
    {
        if ($this->total_quizzes_completed === 0) {
            return 0;
        }

        return round(($this->correct_answers / $this->total_quizzes_completed) * 100, 2);
    }
}
