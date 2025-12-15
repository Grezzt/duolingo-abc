<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learning Menu</title>
  <link rel="stylesheet" href="css/learning.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<div class="header">
  <div class="header-left">
    <a href="dash.php" class="back-btn">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M15 18L9 12L15 6"
          stroke="white" stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"/>
      </svg>
    </a>
    <span class="page-title">Learning</span>
  </div>

  <div class="avatar">
    <img id="userAvatar" src="img/avatar1.png" alt="Avatar">
  </div>
</div>

<!-- ================= MAIN ================= -->
<div class="main-container">

  <!-- GREETING -->
  <div class="greeting">
    <h2 id="userName">Hello, User</h2>
    <h3>Let’s learning with <br> Me</h3>
  </div>

  <div class="content-area">

    <!-- MASCOT -->
    <div class="mascot-section">
      <img src="img/mascot-learn.png" class="big-mascot" alt="Mascot">
    </div>

    <!-- MENU -->
    <div class="menu-section">

      <div class="decoration-img">
        <img src="img/anomali.png" alt="Animals">
      </div>

      <div class="category-grid">

        <div class="cat-btn" data-link="mammals.php">
          <div class="icon-circle">
            <img src="img/mammals.png">
          </div>
          <span>Mammals</span>
        </div>

        <div class="cat-btn" data-link="birds.php">
          <div class="icon-circle">
            <img src="img/birds.png">
          </div>
          <span>Birds</span>
        </div>

        <div class="cat-btn" data-link="sea.php">
          <div class="icon-circle">
            <img src="img/fish.png">
          </div>
          <span>Sea Animals</span>
        </div>

        <div class="cat-btn" data-link="insects.php">
          <div class="icon-circle">
            <img src="img/insect.png">
          </div>
          <span>Insects</span>
        </div>

        <div class="cat-btn" data-link="reptils.php">
          <div class="icon-circle">
            <img src="img/reptile.png">
          </div>
          <span>Reptils</span>
        </div>

        <div class="cat-btn" data-link="amphibi.php">
          <div class="icon-circle">
            <img src="img/amphibi.png">
          </div>
          <span>Amphibi</span>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ================= FOOTER ================= -->
<footer>
  <div class="footer-text">
    KidsLearn © 2025 — Belajar Dengan Senang!
  </div>
  <div class="icons">
    <img src="ig.png">
    <img src="x.png">
    <img src="fb.png">
  </div>
</footer>

<!-- ================= JS USER ================= -->
<script>
  const user = JSON.parse(localStorage.getItem("user"));

  if (!user) {
    window.location.href = "index.php";
  } else {
    document.getElementById("userName").innerText = "Hello, " + user.nama;
    document.getElementById("userAvatar").src = user.avatar;
  }
</script>

<!-- ================= JS ANIMASI & NAVIGASI ================= -->
<script>
  const buttons = document.querySelectorAll(".cat-btn");

  // animasi masuk satu per satu
  buttons.forEach((btn, index) => {
    setTimeout(() => {
      btn.style.opacity = "1";
      btn.style.transform = "translateY(0)";
    }, index * 120);
  });

  // klik → efek + redirect
  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      btn.style.transform = "scale(0.9)";
      setTimeout(() => {
        const link = btn.dataset.link;
        if (link) window.location.href = link;
      }, 180);
    });
  });
</script>

</body>
</html>
