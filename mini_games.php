<?php
$result = "";
$message = "";

if (isset($_POST['answer'])) {
    if ($_POST['answer'] === "cat") {
        $result = "correct";
        $message = "🎉 Jawaban kamu BENAR! Ini adalah hewan mamalia yaitu KUCING.";
    } else {
        $result = "wrong";
        $message = "❌ Jawaban kamu kurang tepat. Coba lagi ya!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini Games - Guess the Animal</title>
    <link rel="stylesheet" href="css/mini_games.css">
</head>
<body>

<div class="header">
    <a href="dash.php" class="back-btn">⬅</a>
    <div class="title">
        <h3>Mini Games – Guess the Animal</h3>
        <p>Lets learn about animals</p>
    </div>
    <img src="img/mascot-regis.png" class="mascot">
</div>

<div class="game-box">
    <img src="img/kucing.png" alt="Animal">
</div>

<h3 class="question">what mammals is this ?</h3>

<form method="POST">
    <div class="answers">
        <label>
            <input type="radio" name="answer" value="cat">
            <span>CAT</span>
        </label>
        <label>
            <input type="radio" name="answer" value="dog">
            <span>DOG</span>
        </label>
        <label>
            <input type="radio" name="answer" value="cow">
            <span>COW</span>
        </label>
        <label>
            <input type="radio" name="answer" value="ant">
            <span>ANT</span>
        </label>
    </div>

    <button type="submit" class="check-btn">PERIKSA</button>
</form>

<?php if ($message): ?>
    <div class="result <?= $result ?>">
        <?= $message ?>
    </div>
<?php endif; ?>

<footer>
    KidsLearn © 2025 — Belajar Dengan Senang!
    <div class="icons">
        <img src="ig.png">
        <img src="x.png">
        <img src="fb.png">
    </div>
</footer>

</body>
</html>