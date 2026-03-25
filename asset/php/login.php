<?php
// Connexion à la BDD + démarrage de session
require 'header.php';

$erreur = '';

// Traitement du formulaire de connexion
if (isset($_POST['mail'])) {
    // Cherche l'utilisateur par son email
    $req = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = ?');
    $req->execute([$_POST['mail']]);
    $user = $req->fetch();

    // Vérifie le mot de passe (hashé en BDD)
    if ($user && password_verify($_POST['password'], $user['mdp'])) {
        $_SESSION['conecter'] = true;
        header('location:admin.php');
        die;
    } else {
        $erreur = 'Email ou mot de passe incorrect.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion — Portfolio Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../style/admin.css">
</head>
<body>

<!-- Page de connexion centrée -->
<div class="login-page">
  <div class="login-card">

    <div class="login-logo">
      <h1>Mon<span>Portfolio</span></h1>
      <p class="login-sub">Espace admin — connecte-toi</p>
    </div>

    <!-- Message d'erreur si mauvais identifiants -->
    <?php if ($erreur): ?>
      <div class="login-error"><i class="fa-solid fa-circle-exclamation"></i> <?= $erreur ?></div>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form method="POST">
      <div class="form-group">
        <label>Adresse email</label>
        <input type="email" name="mail" required autofocus placeholder="ton@email.com">
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" required placeholder="••••••••">
      </div>
      <div class="form-actions" style="border:none;padding:0;margin-top:1.5rem">
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
          <i class="fa-solid fa-right-to-bracket"></i> Se connecter
        </button>
      </div>
    </form>

  </div>
</div>

</body>
</html>
