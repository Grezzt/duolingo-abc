<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Learning - Animals Mammals</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/mammals.css">
</head>
<body>

<header class="top-bar">
  <a href="learning.php" class="back-btn">←</a>
  <div class="title">
    <h2>Learning - Animals Mammals</h2>
    <p>Lets learn about animals</p>
  </div>
</header>

<!-- MASKOT -->
<div class="mascot-wrap">
  <img src="img/mascot_learning.png" alt="Mascot">
</div>

<!-- CARD -->
<div class="animal-card">
  <img class="bg" src="img/taman.jpg" alt="Background">
  <img id="animalImage" class="animal" src="img/dog1.png" alt="Animal">
</div>

<!-- CONTROLS -->
<div class="controls">
  <button class="nav-btn" onclick="prevAnimal()">⬅</button>
  <button class="sound-btn" onclick="playSound()">🔊</button>
  <h3 id="animalName">Dog</h3>
  <button class="nav-btn" onclick="nextAnimal()">➡</button>
</div>

<!-- DESCRIPTION -->
<p class="description" id="animalDesc">
  has four legs, eats meat, vegetables, and fruits.
  Easy to play with, has a distinctive voice.
</p>

<footer>
  KidsLearn © 2025 — Belajar Dengan Senang!
  <div class="icons">
    <img src="ig.png">
    <img src="x.png">
    <img src="fb.png">
  </div>
</footer>

<script src="js/mammals.js"></script>
</body>
</html>
