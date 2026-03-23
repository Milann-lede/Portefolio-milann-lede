<?php

    require 'header.php';
  
if(isset($_POST['mail']))
{
    $req = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = ?');
    $req->execute([$_POST['mail']]);
    $user = $req->fetch();

  if (password_verify($_POST['password'], $user['mdp']))
    {
      echo 'le mot de passe et bon';
      $_SESSION['conecter'] = true;
      header('location:admin.php'); 
      die;
    }

  else
    {
      echo ' le mot de passe et faux';
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

  <form method="POST">
    <label>mail d'utilisateur<br>
      <input type="text" name="mail" required autofocus>
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
