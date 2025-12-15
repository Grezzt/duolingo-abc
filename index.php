<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Anak</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="bg-cloud"></div>

<div class="login-card">
  <img src="mascot-login.png" class="mascot wiggle">
  <div id="loginMessage" class="login-message"></div>
  <h1>👋 Halo Teman!</h1>
  <p>Yuk masuk ke dunia belajar 🚀</p>

  <!-- TAMBAH ID -->
  <input id="loginNama" type="text" placeholder="🧒 Nama Kamu">
  <input id="loginPassword" type="password" placeholder="🔒 Kata Sandi">

  <!-- TAMBAH onclick -->
  <button class="btn-main" onclick="login()">🚀 Masuk</button>

  <a href="register.php" class="link">📝 Daftar di sini</a>
</div>

<!-- HUBUNGKAN KE JS -->
<script src="js/login.js"></script>
</body>
</html>
