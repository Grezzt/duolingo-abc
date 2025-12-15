@extends('layouts.app')

@section('title', 'Daftar - KidsLearn')

@section('content')
    <div class="bg-cloud"></div>

    <div class="login-card">
        <img src="{{ asset('img/mascot-regis.png') }}" class="mascot wiggle" alt="Mascot">

        <h1>🎉 Yuk Daftar!</h1>
        <p>Buat akun seru kamu ✨</p>

        <div class="avatar-box">
            <img src="{{ asset('img/avatar1.png') }}" class="avatar" id="mainAvatar" alt="Avatar">
            <button class="btn-avatar" onclick="openAvatar()">🎨 Ganti Avatar</button>
        </div>

        <input id="regisNama" type="text" placeholder="🧒 Nama Kamu">
        <input id="regisPassword" type="password" placeholder="🔒 Kata Sandi">
        <input id="regisConfirm" type="password" placeholder="🔁 Ulangi Kata Sandi">

        <button class="btn-main" onclick="register()">✅ Daftar</button>

        <div id="regisMessage" class="regis-message"></div>

        <a href="{{ route('login') }}" class="link">⬅️ Kembali ke Login</a>
    </div>

    <!-- POPUP AVATAR -->
    <div class="avatar-overlay" id="avatarOverlay">
        <div class="avatar-popup">
            <div class="popup-header">
                <span>🎨 Pilih Avatar</span>
                <button class="close-btn" onclick="closeAvatar()">✖</button>
            </div>

            <div class="avatar-grid">
                <img src="{{ asset('img/avatar1.png') }}" onclick="selectAvatar(this)">
                <img src="{{ asset('img/avatar2.png') }}" onclick="selectAvatar(this)">
                <img src="{{ asset('img/avatar3.png') }}" onclick="selectAvatar(this)">
                <img src="{{ asset('img/avatar4.png') }}" onclick="selectAvatar(this)">
                <img src="{{ asset('img/avatar5.png') }}" onclick="selectAvatar(this)">
                <img src="{{ asset('img/avatar6.png') }}" onclick="selectAvatar(this)">
            </div>
        </div>
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

        .avatar-box {
            margin: 20px 0;
        }

        .avatar-box .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #667eea;
            margin-bottom: 10px;
        }

        .btn-avatar {
            padding: 8px 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-avatar:hover {
            background: #5568d3;
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

        .regis-message {
            padding: 10px;
            margin: 15px 0;
            border-radius: 8px;
            font-weight: bold;
            display: none;
        }

        .regis-message.error {
            display: block;
            background: #ffe0e0;
            color: #d32f2f;
        }

        .regis-message.success {
            display: block;
            background: #e0ffe0;
            color: #2f8d32;
        }

        /* Avatar Popup */
        .avatar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .avatar-popup {
            background: white;
            padding: 20px;
            border-radius: 15px;
            max-width: 400px;
            width: 90%;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .close-btn {
            background: #ff5555;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 16px;
        }

        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .avatar-grid img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            border: 3px solid transparent;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s;
        }

        .avatar-grid img:hover {
            transform: scale(1.1);
            border-color: #667eea;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const overlay = document.getElementById("avatarOverlay");
        const avatarMain = document.getElementById("mainAvatar");
        const message = document.getElementById("regisMessage");

        let selectedAvatar = "{{ asset('img/avatar1.png') }}";

        function openAvatar() {
            overlay.style.display = "flex";
        }

        function closeAvatar() {
            overlay.style.display = "none";
        }

        function selectAvatar(el) {
            selectedAvatar = el.src;
            avatarMain.src = el.src;
            closeAvatar();
        }

        function register() {
            const nama = document.getElementById("regisNama").value.trim();
            const password = document.getElementById("regisPassword").value;
            const confirm = document.getElementById("regisConfirm").value;

            message.className = "regis-message";
            message.textContent = "";

            if (!nama || !password || !confirm) {
                message.textContent = "✍️ Lengkapi semua data dulu ya!";
                message.classList.add("error");
                return;
            }

            if (password !== confirm) {
                message.textContent = "❌ Kata sandi tidak sama";
                message.classList.add("error");
                return;
            }

            // Get avatar filename only
            const avatarFilename = selectedAvatar.split('/').pop();

            // Send AJAX request
            fetch("{{ route('register.post') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: nama,
                        password: password,
                        password_confirmation: confirm,
                        avatar: avatarFilename
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = data.message;
                        message.classList.add("success");
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1200);
                    } else {
                        message.textContent = data.message || "❌ Terjadi kesalahan";
                        message.classList.add("error");
                    }
                })
                .catch(error => {
                    message.textContent = "❌ Nama sudah digunakan atau terjadi kesalahan";
                    message.classList.add("error");
                });
        }
    </script>
@endpush
