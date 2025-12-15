<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    /**
     * Show learning menu
     */
    public function index()
    {
        $categories = Animal::getCategories();

        return view('learning.index', compact('categories'));
    }

    /**
     * Show animals by category
     */
    public function category($category)
    {
        $animals = Animal::getByCategory($category);

        if ($animals->isEmpty()) {
            return redirect()->route('learning.index')
                ->with('error', 'Kategori tidak ditemukan');
        }

        $categoryName = Animal::getCategories()[$category] ?? $category;

        return view('learning.category', compact('animals', 'category', 'categoryName'));
    }

    /**
     * Get animals data for AJAX
     */
    public function getAnimals($category)
    {
        $animals = Animal::getByCategory($category);

        return response()->json([
            'success' => true,
            'animals' => $animals
        ]);
    }
}
