@extends('layouts.app')

@section('title', 'Login - KidsLearn')

@section('content')
    <div class="bg-cloud"></div>

    <div class="login-card">
        <img src="{{ asset('img/mascot-login.png') }}" class="mascot wiggle" alt="Mascot">
        <div id="loginMessage" class="login-message"></div>
        <h1>👋 Halo Teman!</h1>
        <p>Yuk masuk ke dunia belajar 🚀</p>

        <input id="loginNama" type="text" placeholder="🧒 Nama Kamu">
        <input id="loginPassword" type="password" placeholder="🔒 Kata Sandi">

        <button class="btn-main" onclick="login()">🚀 Masuk</button>

        <a href="{{ route('register') }}" class="link">📝 Daftar di sini</a>
    </div>
@endsection

@push('styles')
    <style>
        .bg-cloud {
            position: fixed;
            width: 100%;
            height: 100%;
            background: url('{{ asset('img/cloud-bg.png') }}') repeat;
            opacity: 0.1;
            z-index: -1;
        }

        .login-card {
            position: relative;
            width: 90%;
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .mascot {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-card h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .login-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .login-card input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .login-card input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-main {
            width: 100%;
            padding: 15px;
            margin: 20px 0 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-main:hover {
            transform: scale(1.05);
        }

        .link {
            display: block;
            margin-top: 15px;
            color: #667eea;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .login-message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-weight: bold;
            display: none;
        }

        .login-message.error {
            display: block;
            background: #ffe0e0;
            color: #d32f2f;
        }

        .login-message.success {
            display: block;
            background: #e0ffe0;
            color: #2f8d32;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function login() {
            const nama = document.getElementById("loginNama").value.trim();
            const password = document.getElementById("loginPassword").value;
            const message = document.getElementById("loginMessage");
            const card = document.querySelector(".login-card");

            message.className = "login-message";
            message.textContent = "";

            if (!nama || !password) {
                message.textContent = "✍️ Isi nama dan kata sandi dulu ya!";
                message.classList.add("error");
                card.classList.add("shake");
                setTimeout(() => card.classList.remove("shake"), 400);
                return;
            }

            // Send AJAX request
            fetch("{{ route('login.post') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: nama,
                        password: password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = data.message;
                        message.classList.add("success");
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        message.textContent = data.message;
                        message.classList.add("error");
                        card.classList.add("shake");
                        setTimeout(() => card.classList.remove("shake"), 400);
                    }
                })
                .catch(error => {
                    message.textContent = "❌ Ups! Nama atau kata sandi salah";
                    message.classList.add("error");
                    card.classList.add("shake");
                    setTimeout(() => card.classList.remove("shake"), 400);
                });
        }

        // Allow Enter key to submit
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginPassword').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    login();
                }
            });
        });
    </script>
@endpush
