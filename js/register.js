const overlay = document.getElementById("avatarOverlay");
const avatarMain = document.getElementById("mainAvatar");
const message = document.getElementById("regisMessage");

let selectedAvatar = avatarMain.src;

/* POPUP AVATAR */
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

/* REGISTER DUMMY */
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

  const user = {
    nama,
    password,
    avatar: selectedAvatar
  };

  localStorage.setItem("user", JSON.stringify(user));

  message.textContent = "🎉 Hore! Akun berhasil dibuat!";
  message.classList.add("success");

  setTimeout(() => {
    window.location.href = "index.php";
  }, 1200);
}
