@extends('layouts.app')

@section('title', 'Learning ' . $categoryName . ' - KidsLearn')

@section('content')
    <header class="top-bar">
        <a href="{{ route('learning.index') }}" class="back-btn">←</a>
        <div class="title">
            <h2>Learning - {{ $categoryName }}</h2>
            <p>Lets learn about animals</p>
        </div>
    </header>

    <div class="mascot-wrap">
        <img src="{{ asset('img/mascot_learning.png') }}" alt="Mascot">
    </div>

    <div class="animal-card">
        <img class="bg" src="{{ asset('img/taman.jpg') }}" alt="Background">
        <img id="animalImage" class="animal" src="{{ asset($animals[0]->image_path) }}" alt="Animal">
    </div>

    <div class="controls">
        <button class="nav-btn" onclick="prevAnimal()">⬅</button>
        <button class="sound-btn" onclick="playSound()">🔊</button>
        <h3 id="animalName">{{ $animals[0]->name }}</h3>
        <button class="nav-btn" onclick="nextAnimal()">➡</button>
    </div>

    <p class="description" id="animalDesc">
        {{ $animals[0]->description }}
    </p>

    <footer>
        KidsLearn © 2025 — Belajar Dengan Senang!
        <div class="icons">
            <img src="{{ asset('img/ig.png') }}" alt="Instagram">
            <img src="{{ asset('img/twt.png') }}" alt="Twitter">
            <img src="{{ asset('img/fb.png') }}" alt="Facebook">
        </div>
    </footer>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .top-bar {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 28px;
        }

        .title {
            color: white;
        }

        .title h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .title p {
            font-size: 14px;
            opacity: 0.9;
        }

        .mascot-wrap {
            text-align: center;
            margin: 20px 0;
        }

        .mascot-wrap img {
            width: 100px;
        }

        .animal-card {
            position: relative;
            max-width: 500px;
            margin: 0 auto 30px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .animal-card .bg {
            width: 100%;
            display: block;
        }

        .animal-card .animal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 60%;
            max-height: 60%;
        }

        .controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
        }

        .nav-btn {
            width: 50px;
            height: 50px;
            background: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .nav-btn:hover {
            transform: scale(1.1);
        }

        .sound-btn {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50%;
            font-size: 28px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .sound-btn:hover {
            transform: scale(1.1);
        }

        .controls h3 {
            font-size: 28px;
            color: white;
            margin: 0 10px;
            min-width: 150px;
            text-align: center;
        }

        .description {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            text-align: center;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const animals = @json($animals);

        let index = 0;

        const imgEl = document.getElementById("animalImage");
        const nameEl = document.getElementById("animalName");
        const descEl = document.getElementById("animalDesc");

        function updateAnimal() {
            imgEl.src = '{{ asset('') }}' + animals[index].image_path;
            nameEl.innerText = animals[index].name;
            descEl.innerText = animals[index].description;
        }

        function nextAnimal() {
            index = (index + 1) % animals.length;
            updateAnimal();
        }

        function prevAnimal() {
            index = (index - 1 + animals.length) % animals.length;
            updateAnimal();
        }

        function playSound() {
            if (animals[index].sound_path) {
                const audio = new Audio('{{ asset('') }}' + animals[index].sound_path);
                audio.play();
            } else {
                alert('🔇 Suara tidak tersedia untuk hewan ini');
            }
        }
    </script>
@endpush
