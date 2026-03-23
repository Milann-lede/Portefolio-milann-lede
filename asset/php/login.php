<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Identifiants incorrects.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
</head>
<body>
  <h1>Connexion</h1>

  <?php if ($error): ?>
    <p><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST">
    <label>Nom d'utilisateur<br>
      <input type="text" name="username" required autofocus>
    </label>
    <br><br>
    <label>Mot de passe<br>
      <input type="password" name="password" required>
    </label>
    <br><br>
    <button type="submit">Se connecter</button>
  </form>
</body>
</html>
