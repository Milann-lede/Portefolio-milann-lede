<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Récupère les compétences triées par ordre d'affichage (ORDER BY ordre ASC = du plus petit au plus grand)
$result      = $bdd->query('SELECT * FROM mes_competences ORDER BY ordre ASC');
$competences = $result->fetchAll();

$pageTitle  = 'Compétences';
$activePage = 'competences';
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

  <div class="page-header">
    <h1>Mes compétences</h1>
    <a href="ajout.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Ajouter</a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Nom</th><th>Niveau</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($competences as $c): // Boucle : une ligne par compétence ?>
          <tr>
            <td style="color:var(--muted2)"><?= $c['ordre'] ?></td>
            <td><strong><?= $c['nom'] ?></strong></td>
            <td>
              <div class="skill-bar-wrap">
                <div class="skill-bar-mini">
                  <?php // (int) convertit en entier — la largeur de la barre = le pourcentage ?>
                  <div class="skill-bar-fill" style="width:<?= (int)$c['pourcentage'] ?>%"></div>
                </div>
                <span class="skill-pct"><?= $c['pourcentage'] ?>%</span>
              </div>
            </td>
            <td>
              <div class="actions-cell">
                <a href="modif.php?id=<?= $c['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-pen"></i> Modifier</a>
                <a href="supprimer.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette compétence ?')"><i class="fa-solid fa-trash"></i></a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

    </div>
  </main>
</div>
</body>
</html>
