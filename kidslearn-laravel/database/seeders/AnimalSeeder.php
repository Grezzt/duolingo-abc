<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            // Mammals
            [
                'name' => 'Dog',
                'category' => 'mammals',
                'description' => 'has four legs, eats meat, vegetables, and fruits. Easy to play with, has a distinctive voice.',
                'image_path' => 'img/dog1.png',
                'sound_path' => 'sound/dog.mp3'
            ],
            [
                'name' => 'Elephant',
                'category' => 'mammals',
                'description' => 'has four legs, eats grass, leaves, tree bark, roots, fruit, and twigs. has a large body, wide ears, and a long trunk.',
                'image_path' => 'img/elephant.png',
                'sound_path' => 'sound/Elephant.mp3'
            ],
            [
                'name' => 'Cat',
                'category' => 'mammals',
                'description' => 'has four legs, sharp claws, and loves to climb. Very independent and loves to sleep.',
                'image_path' => 'img/kucing.png',
                'sound_path' => 'sound/cat.mp3'
            ],
            [
                'name' => 'Cow',
                'category' => 'mammals',
                'description' => 'has four legs, eats grass and gives us milk. Says "moo" and lives on farms.',
                'image_path' => 'img/cow.png',
                'sound_path' => 'sound/cow.mp3'
            ],
            // Birds
            [
                'name' => 'Eagle',
                'category' => 'birds',
                'description' => 'has wings and can fly very high. Sharp talons and excellent eyesight.',
                'image_path' => 'img/eagle.png',
                'sound_path' => 'sound/eagle.mp3'
            ],
            [
                'name' => 'Parrot',
                'category' => 'birds',
                'description' => 'colorful bird that can mimic human speech. Very intelligent and social.',
                'image_path' => 'img/parrot.png',
                'sound_path' => 'sound/parrot.mp3'
            ],
            // Sea Animals
            [
                'name' => 'Dolphin',
                'category' => 'sea',
                'description' => 'intelligent marine mammal that loves to play. Can swim very fast.',
                'image_path' => 'img/dolphin.png',
                'sound_path' => 'sound/dolphin.mp3'
            ],
            [
                'name' => 'Shark',
                'category' => 'sea',
                'description' => 'large fish with sharp teeth. King of the ocean.',
                'image_path' => 'img/shark.png',
                'sound_path' => 'sound/shark.mp3'
            ],
            // Insects
            [
                'name' => 'Butterfly',
                'category' => 'insects',
                'description' => 'beautiful insect with colorful wings. Loves flowers and nectar.',
                'image_path' => 'img/butterfly.png',
                'sound_path' => null
            ],
            [
                'name' => 'Ant',
                'category' => 'insects',
                'description' => 'very small but very strong. Works in groups and builds colonies.',
                'image_path' => 'img/ant.png',
                'sound_path' => null
            ],
            // Reptiles
            [
                'name' => 'Snake',
                'category' => 'reptils',
                'description' => 'long body with no legs. Moves by slithering on the ground.',
                'image_path' => 'img/snake.png',
                'sound_path' => 'sound/snake.mp3'
            ],
            [
                'name' => 'Crocodile',
                'category' => 'reptils',
                'description' => 'large reptile with strong jaws. Lives in water and on land.',
                'image_path' => 'img/crocodile.png',
                'sound_path' => 'sound/crocodile.mp3'
            ],
            // Amphibians
            [
                'name' => 'Frog',
                'category' => 'amphibi',
                'description' => 'can live in water and on land. Can jump very high.',
                'image_path' => 'img/frog.png',
                'sound_path' => 'sound/frog.mp3'
            ],
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
