@extends('layouts.app')

@section('title', 'Dashboard - KidsLearn')

@section('content')
    <div class="navbar">
        <div class="menu-icon">☰</div>
        <div class="avatar">
            <img id="userAvatar" src="{{ asset($user->avatar) }}" alt="Avatar">
        </div>
    </div>

    <div class="level-box">
        <div class="level-text">Level {{ $progress->level }}</div>
        <div class="level-bar">
            <div class="level-fill" style="width: {{ $progress->xp % 100 }}%"></div>
        </div>
    </div>

    <div class="hero">
        <h2 id="userName">Hello, {{ $user->name }}</h2>
        <h3>Let's learning with Me</h3>
    </div>

    <div class="container">
        <img src="{{ asset('img/mascot-login.png') }}" class="mascot" alt="Mascot">

        <div class="boxes">
            <a href="{{ route('learning.index') }}" class="box-link">
                <div class="box">Learning</div>
            </a>
            <a href="{{ route('quiz.index') }}" class="box-link">
                <div class="box">Mini Games</div>
            </a>
            <div class="box" onclick="alert('Coming Soon!')">Quiz</div>
        </div>
    </div>

    <footer>
        KidsLearn © 2025 — Belajar Dengan Senang!
        <div class="icons">
            <img src="{{ asset('img/ig.png') }}" alt="Instagram">
            <img src="{{ asset('img/twt.png') }}" alt="Twitter">
            <img src="{{ asset('img/fb.png') }}" alt="Facebook">
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit"
                style="background: #ff5555; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                🚪 Logout
            </button>
        </form>
    </footer>
@endsection

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .menu-icon {
            font-size: 28px;
            color: white;
            cursor: pointer;
        }

        .avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .level-box {
            margin: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            text-align: center;
        }

        .level-text {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }

        .level-bar {
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .level-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }

        .hero {
            text-align: center;
            padding: 20px;
            color: white;
        }

        .hero h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .hero h3 {
            font-size: 20px;
            opacity: 0.9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .mascot {
            display: block;
            width: 150px;
            margin: 0 auto 30px;
        }

        .boxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .box-link {
            text-decoration: none;
        }

        .box {
            padding: 40px 20px;
            background: white;
            border-radius: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        footer {
            margin-top: 40px;
        }
    </style>
@endpush
