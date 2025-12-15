<?php /* dashboard */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gamifikasi</title>
    <link rel="stylesheet" href="css/dash.css">
</head>
<body>

<div class="navbar">
    <div class="menu-icon">☰</div>
    <div class="avatar">
        <!-- AVATAR USER -->
        <img id="userAvatar" src="2.png" alt="Avatar">
    </div>
</div>

<div class="level-box">
    <div class="level-text">Level 4</div>
    <div class="level-bar">
        <div class="level-fill"></div>
    </div>
</div>

<div class="hero">
    <h2 id="userName">Hello, User</h2>
    <h3>Let's learning with Me</h3>
</div>

<div class="container">
    <img src="mascot-login.png" class="mascot" alt="Mascot">

    <div class="boxes">
            <a href="learning.php" class="box-link">
                <div class="box">Learning</div>
            </a>
            <a href="mini_games.php" class="box-link">
                <div class="box">Mini Games</div>
            </a>

        <div class="box">Quiz</div>
    </div>
</div>

<footer>
    KidsLearn © 2025 — Belajar Dengan Senang!
    <div class="icons">
        <img src="ig.png">
        <img src="twt.png">
        <img src="fb.png">
    </div>
</footer>

<!-- JS DASH -->
<script>
  const user = JSON.parse(localStorage.getItem("user"));

  if (!user) {
    // kalau belum login, paksa balik ke login
    window.location.href = "index.php";
  } else {
    document.getElementById("userName").innerText = "Hello, " + user.nama;
    document.getElementById("userAvatar").src = user.avatar;
  }
</script>

</body>
</html>