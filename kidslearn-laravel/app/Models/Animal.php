<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'image_path',
        'sound_path',
    ];

    /**
     * Get animals by category
     */
    public static function getByCategory(string $category)
    {
        return self::where('category', $category)->get();
    }

    /**
     * Get all categories
     */
    public static function getCategories(): array
    {
        return [
            'mammals' => 'Mammals',
            'birds' => 'Birds',
            'sea' => 'Sea Animals',
            'insects' => 'Insects',
            'reptils' => 'Reptils',
            'amphibi' => 'Amphibi',
        ];
    }
}
