<?php
// Connexion BDD + démarrage de session
require 'header.php';

// Redirige vers login si l'utilisateur n'est pas connecté
if (!isset($_SESSION['conecter'])) {
    header('location:login.php');
    die;
}

// Récupère les statistiques pour le dashboard
$result  = $bdd->query('SELECT * FROM projet');
$projets = $result->fetchAll();

// fetchColumn() récupère uniquement le résultat du COUNT() — un simple nombre
$totalSpec = $bdd->query('SELECT COUNT(*) FROM Specialise')->fetchColumn();
$totalComp = $bdd->query('SELECT COUNT(*) FROM mes_competences')->fetchColumn();

// Titre de la page et lien actif dans la sidebar
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
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
  <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
<div class="admin-layout">

  <!-- Sidebar de navigation -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <strong>Mon<span>Portfolio</span></strong>
      <small>Espace admin</small>
    </div>
    <nav class="sidebar-nav">
      <?php // Condition ternaire : ajoute la classe "active" si c'est la page courante ?>
      <a href="admin.php" class="nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Dashboard</a>
      <a href="projet/liste.php" class="nav-item <?= $activePage === 'projets' ? 'active' : '' ?>"><i class="fa-solid fa-folder"></i> Projets</a>
      <a href="specialite/liste.php" class="nav-item <?= $activePage === 'specialites' ? 'active' : '' ?>"><i class="fa-solid fa-code"></i> Spécialisé en</a>
      <a href="competence/liste.php" class="nav-item <?= $activePage === 'competences' ? 'active' : '' ?>"><i class="fa-solid fa-chart-simple"></i> Compétences</a>
      <a href="parcours/liste.php" class="nav-item <?= $activePage === 'parcours' ? 'active' : '' ?>"><i class="fa-solid fa-graduation-cap"></i> Parcours</a>
      <a href="apropos/liste.php" class="nav-item <?= $activePage === 'apropos' ? 'active' : '' ?>"><i class="fa-regular fa-user"></i> À propos</a>
      <a href="cv/index.php" class="nav-item <?= $activePage === 'cv' ? 'active' : '' ?>"><i class="fa-regular fa-file-pdf"></i> Mon CV</a>
      <a href="../../index.php" target="_blank" class="nav-item" style="margin-top:auto"><i class="fa-solid fa-arrow-up-right-from-square"></i> Voir le site</a>
    </nav>
    <div class="sidebar-footer">
      <a href="deconnexion.php" class="nav-item logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
    </div>
  </aside>

  <!-- Contenu principal -->
  <main class="admin-main">
    <div class="admin-topbar">
      <span class="topbar-title"><?= $pageTitle ?></span>
      <div class="topbar-right"><a href="../../index.php" target="_blank">Voir le portfolio →</a></div>
    </div>
    <div class="admin-content">

<!-- Statistiques rapides -->
<div class="stat-grid">
  <div class="stat-card">
    <?php // count() compte le nombre d'éléments dans le tableau $projets ?>
    <div class="stat-value"><?= count($projets) ?></div>
    <div class="stat-label">Projets</div>
  </div>
  <div class="stat-card">
    <div class="stat-value"><?= $totalSpec ?></div>
    <div class="stat-label">Spécialités</div>
  </div>
  <div class="stat-card">
    <div class="stat-value"><?= $totalComp ?></div>
    <div class="stat-label">Compétences</div>
  </div>
</div>

<!-- Raccourcis vers chaque section -->
<div class="section-label">Actions rapides</div>
<div class="quick-grid">
  <a href="projet/liste.php" class="quick-card">
    <div class="quick-card-icon"><i class="fa-solid fa-folder"></i></div>
    <div class="quick-card-text"><span>Projets</span><small>Gérer mes projets</small></div>
  </a>
  <a href="specialite/liste.php" class="quick-card">
    <div class="quick-card-icon"><i class="fa-solid fa-code"></i></div>
    <div class="quick-card-text"><span>Spécialités</span><small>Technologies affichées</small></div>
  </a>
  <a href="competence/liste.php" class="quick-card">
    <div class="quick-card-icon"><i class="fa-solid fa-chart-simple"></i></div>
    <div class="quick-card-text"><span>Compétences</span><small>Niveaux & pourcentages</small></div>
  </a>
  <a href="parcours/liste.php" class="quick-card">
    <div class="quick-card-icon"><i class="fa-solid fa-graduation-cap"></i></div>
    <div class="quick-card-text"><span>Parcours</span><small>Formations & expériences</small></div>
  </a>
  <a href="apropos/liste.php" class="quick-card">
    <div class="quick-card-icon"><i class="fa-regular fa-user"></i></div>
    <div class="quick-card-text"><span>À propos</span><small>Contenu de la page</small></div>
  </a>
  <a href="cv/index.php" class="quick-card">
    <div class="quick-card-icon"><i class="fa-regular fa-file-pdf"></i></div>
    <div class="quick-card-text"><span>Mon CV</span><small>Mettre à jour le PDF</small></div>
  </a>
</div>

    </div>
  </main>
</div>
</body>
</html>
