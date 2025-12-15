<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $avatar
 * @property string $password
 * @property-read UserProgress|null $progress
 *
 * @method UserProgress getOrCreateProgress()
 * @method HasOne progress()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's progress.
     */
    public function progress()
    {
        return $this->hasOne(UserProgress::class);
    }

    /**
     * Get or create user progress
     */
    public function getOrCreateProgress(): UserProgress
    {
        // Load the relationship if not already loaded
        if (!$this->relationLoaded('progress')) {
            $this->load('progress');
        }

        // If no progress exists, create one
        if (!$this->progress) {
            $progress = UserProgress::create([
                'user_id' => $this->id,
                'level' => 1,
                'xp' => 0,
                'total_quizzes_completed' => 0,
                'correct_answers' => 0,
            ]);

            // Update the relationship
            $this->setRelation('progress', $progress);

            return $progress;
        }

        return $this->progress;
    }
}
