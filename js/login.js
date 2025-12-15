function login() {
  const nama = document.getElementById("loginNama").value.trim();
  const password = document.getElementById("loginPassword").value;

  const user = JSON.parse(localStorage.getItem("user"));
  const message = document.getElementById("loginMessage");
  const card = document.querySelector(".login-card");

  message.className = "login-message";
  message.textContent = "";

  if (!user) {
    message.textContent = "😢 Belum punya akun, ayo daftar dulu!";
    message.classList.add("error");
    return;
  }

  if (!nama || !password) {
    message.textContent = "✍️ Isi nama dan kata sandi dulu ya!";
    message.classList.add("error");
    card.classList.add("shake");
    setTimeout(() => card.classList.remove("shake"), 400);
    return;
  }

  if (nama === user.nama && password === user.password) {
    message.textContent = `🎉 Hore! Selamat datang ${user.nama}!`;
    message.classList.add("success");

    // ⬇️ PINDAH KE DASHBOARD
    setTimeout(() => {
      window.location.href = "dash.php";
    }, 1000);

  } else {
    message.textContent = "❌ Ups! Nama atau kata sandi salah";
    message.classList.add("error");
    card.classList.add("shake");
    setTimeout(() => card.classList.remove("shake"), 400);
  }
}
