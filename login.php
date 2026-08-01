<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string)($_POST['password'] ?? '');

    if (password_verify($password, GIFT_PASSWORD_HASH)) {
        session_regenerate_id(true);
        $_SESSION['gift_access'] = true;
        header('Location: index.php');
        exit;
    }

    $error = 'That password did not unlock our universe.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Unlock <?= htmlspecialchars(APP_NAME) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
  <canvas id="stars" aria-hidden="true"></canvas>

  <main class="login-shell">
    <section class="login-card glass-card">
      <p class="eyebrow">Private gift</p>
      <h1 class="login-title">Unlock Our Little Universe</h1>
      <p class="section-description">
        Enter the secret word that belongs only to us.
      </p>

      <?php if ($error !== ''): ?>
        <p class="form-error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="post" class="login-form" autocomplete="off">
        <label for="password">Secret word</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Enter our secret"
          required
          autofocus
        >
        <button class="primary-button" type="submit">Open My Gift ✦</button>
      </form>
    </section>
  </main>

  <script src="assets/js/stars.js"></script>
</body>
</html>
