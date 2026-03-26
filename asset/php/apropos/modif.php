<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Récupère l'id depuis l'URL au chargement, ou depuis le formulaire à la soumission
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = $_POST['id'];
}

// Récupère le bloc de texte à modifier
$req = $bdd->prepare('SELECT * FROM contenu WHERE id = ?');
$req->execute([$id]);
$contenu = $req->fetch();

// Traitement du formulaire de modification
if (isset($_POST['contenu'])) {
    $req = $bdd->prepare('UPDATE contenu SET contenu=? WHERE id=?');
    $req->execute([$_POST['contenu'], $id]);
    header('location:liste.php'); die;
}

$pageTitle  = 'Modifier — ' . $contenu['identifient'];
$activePage = 'apropos';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $pageTitle ?> — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../../style/admin.css">
</head>
<body>
<div class="admin-layout">
  <aside class="sidebar">
    <div class="sidebar-brand"><strong>Mon<span>Portfolio</span></strong><small>Espace admin</small></div>
    <nav class="sidebar-nav">
      <a href="../admin.php" class="nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Dashboard</a>
      <a href="../projet/liste.php" class="nav-item <?= $activePage === 'projets' ? 'active' : '' ?>"><i class="fa-solid fa-folder"></i> Projets</a>
      <a href="../specialite/liste.php" class="nav-item <?= $activePage === 'specialites' ? 'active' : '' ?>"><i class="fa-solid fa-code"></i> Spécialisé en</a>
      <a href="../competence/liste.php" class="nav-item <?= $activePage === 'competences' ? 'active' : '' ?>"><i class="fa-solid fa-chart-simple"></i> Compétences</a>
      <a href="../parcours/liste.php" class="nav-item <?= $activePage === 'parcours' ? 'active' : '' ?>"><i class="fa-solid fa-graduation-cap"></i> Parcours</a>
      <a href="../apropos/liste.php" class="nav-item <?= $activePage === 'apropos' ? 'active' : '' ?>"><i class="fa-regular fa-user"></i> À propos</a>
      <a href="../cv/index.php" class="nav-item <?= $activePage === 'cv' ? 'active' : '' ?>"><i class="fa-regular fa-file-pdf"></i> Mon CV</a>
      <a href="../recomendation/liste.php" class="nav-item <?= $activePage === 'recomendation' ? 'active' : '' ?>"><i class="fa-solid fa-star"></i> Recommandations</a>
      <a href="../../../index.php" target="_blank" class="nav-item" style="margin-top:auto"><i class="fa-solid fa-arrow-up-right-from-square"></i> Voir le site</a>
    </nav>
    <div class="sidebar-footer">
      <a href="../deconnexion.php" class="nav-item logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
    </div>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <span class="topbar-title"><?= $pageTitle ?></span>
      <div class="topbar-right"><a href="../../../index.php" target="_blank">Voir le portfolio →</a></div>
    </div>
    <div class="admin-content">

  <a href="liste.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Retour</a>
  <div class="page-header"><h1>Modifier — <?= $contenu['identifient'] ?></h1></div>

  <form method="POST">
    <div class="form-card">
      <?php // Champ caché : transmet l'id sans l'afficher ?>
      <input type="hidden" name="id" value="<?= $contenu['id'] ?>">
      <div class="form-group">
        <label>Contenu</label>
        <textarea name="contenu" rows="10"><?= $contenu['contenu'] ?></textarea>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
        <a href="liste.php" class="btn btn-ghost">Annuler</a>
      </div>
    </div>
  </form>

    </div>
  </main>
</div>
</body>
</html>
