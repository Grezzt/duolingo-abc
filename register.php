<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun</title>
  <link rel="stylesheet" href="css/regis.css">
</head>
<body>

<div class="bg-cloud"></div>

<div class="login-card">
  <img src="img/mascot-regis.png" class="mascot wiggle">

  <h1>🎉 Yuk Daftar!</h1>
  <p>Buat akun seru kamu ✨</p>

  <div class="avatar-box">
    <img src="img/avatar1.png" class="avatar" id="mainAvatar">
    <button class="btn-avatar" onclick="openAvatar()">🎨 Ganti Avatar</button>
  </div>

  <input id="regisNama" type="text" placeholder="🧒 Nama Kamu">
  <input id="regisPassword" type="password" placeholder="🔒 Kata Sandi">
  <input id="regisConfirm" type="password" placeholder="🔁 Ulangi Kata Sandi">

  <button class="btn-main" onclick="register()">✅ Daftar</button>

  <!-- ✅ PESAN REGIS DI DALAM CARD -->
  <div id="regisMessage" class="regis-message"></div>

  <a href="index.php" class="link">⬅️ Kembali ke Login</a>
</div>

<!-- POPUP AVATAR -->
<div class="avatar-overlay" id="avatarOverlay">
  <div class="avatar-popup">
    <div class="popup-header">
      <span>🎨 Pilih Avatar</span>
      <button class="close-btn" onclick="closeAvatar()">✖</button>
    </div>

    <div class="avatar-grid">
      <img src="img/avatar1.png" onclick="selectAvatar(this)">
      <img src="img/avatar2.png" onclick="selectAvatar(this)">
      <img src="img/avatar3.png" onclick="selectAvatar(this)">
      <img src="img/avatar4.png" onclick="selectAvatar(this)">
      <img src="img/avatar5.png" onclick="selectAvatar(this)">
      <img src="img/avatar6.png" onclick="selectAvatar(this)">
    </div>
  </div>
</div>

<script src="js/register.js"></script>
</body>
</html>
