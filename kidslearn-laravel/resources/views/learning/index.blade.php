@extends('layouts.app')

@section('title', 'Learning - KidsLearn')

@section('content')
    <div class="header">
        <div class="header-left">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <span class="page-title">Learning</span>
        </div>

        <div class="avatar">
            <img id="userAvatar" src="{{ asset(auth()->user()->avatar) }}" alt="Avatar">
        </div>
    </div>

    <div class="main-container">
        <div class="greeting">
            <h2>Hello, {{ auth()->user()->name }}</h2>
            <h3>Let's learning with <br> Me</h3>
        </div>

        <div class="content-area">
            <div class="mascot-section">
                <img src="{{ asset('img/mascot-learn.png') }}" class="big-mascot" alt="Mascot">
            </div>

            <div class="menu-section">
                <div class="decoration-img">
                    <img src="{{ asset('img/anomali.png') }}" alt="Animals">
                </div>

                <div class="category-grid">
                    @foreach ($categories as $key => $name)
                        <a href="{{ route('learning.category', $key) }}" class="cat-btn">
                            <div class="icon-circle">
                                <img src="{{ asset('img/' . $key . '.png') }}" alt="{{ $name }}">
                            </div>
                            <span>{{ $name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 24px;
        }

        .page-title {
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        .avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .greeting {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .greeting h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .greeting h3 {
            font-size: 20px;
            opacity: 0.9;
        }

        .content-area {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .mascot-section {
            flex: 1;
        }

        .big-mascot {
            width: 100%;
            max-width: 250px;
        }

        .menu-section {
            flex: 2;
        }

        .decoration-img {
            text-align: center;
            margin-bottom: 20px;
        }

        .decoration-img img {
            max-width: 200px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .cat-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 15px;
            text-decoration: none;
            color: #333;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cat-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .icon-circle img {
            width: 40px;
            height: 40px;
        }

        .cat-btn span {
            font-weight: bold;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .content-area {
                flex-direction: column;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush
