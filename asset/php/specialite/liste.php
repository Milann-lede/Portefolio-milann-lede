<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Récupère les spécialités triées par pourcentage décroissant (les 6 meilleures s'affichent sur le portfolio)
$result      = $bdd->query('SELECT * FROM Specialise ORDER BY pourcentage DESC');
$specialites = $result->fetchAll();

$pageTitle  = 'Spécialisé en';
$activePage = 'specialites';
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

  <div class="page-header">
    <h1>Spécialisé en</h1>
    <a href="ajout.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Ajouter</a>
  </div>
  <p style="color:var(--muted2);font-size:.85rem;margin-bottom:1.5rem">
    Les 6 spécialités avec le pourcentage le plus élevé s'affichent sur le portfolio.
  </p>

  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Icône</th><th>Nom</th><th>Pourcentage</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($specialites as $s): // Boucle : une ligne par spécialité ?>
          <tr>
            <td>
              <?php if ($s['img'] === 'vscode'): // Icône VS Code (SVG car non disponible en Font Awesome) ?>
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor">
                  <path d="M23.15 2.587L18.21.21a1.494 1.494 0 0 0-1.705.29l-9.46 8.63-4.12-3.128a.999.999 0 0 0-1.276.057L.327 7.261A1 1 0 0 0 .326 8.74L3.899 12 .326 15.26a1 1 0 0 0 .001 1.479L1.65 17.94a.999.999 0 0 0 1.276.057l4.12-3.128 9.46 8.63a1.492 1.492 0 0 0 1.704.29l4.942-2.377A1.5 1.5 0 0 0 24 20.06V3.939a1.5 1.5 0 0 0-.85-1.352zm-5.146 14.861L10.826 12l7.178-5.448v10.896z"/>
                </svg>
              <?php elseif (!empty($s['img']) && substr($s['img'], 0, 3) === 'fa-'): // Icône Font Awesome ?>
                <i class="<?= $s['img'] ?>" style="font-size:1.4rem;color:var(--accent-1)"></i>
              <?php else: // Image uploadée via l'admin ?>
                <img src="../../image/<?= $s['img'] ?>" width="36" height="36">
              <?php endif; ?>
            </td>
            <td><strong><?= $s['nom'] ?></strong></td>
            <td>
              <div class="skill-bar-wrap">
                <div class="skill-bar-mini">
                  <?php // (int) convertit en entier — la largeur de la barre = le pourcentage ?>
                  <div class="skill-bar-fill" style="width:<?= (int)$s['pourcentage'] ?>%"></div>
                </div>
                <span class="skill-pct"><?= (int)$s['pourcentage'] ?>%</span>
              </div>
            </td>
            <td>
              <div class="actions-cell">
                <a href="modif.php?id=<?= $s['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-pen"></i> Modifier</a>
                <a href="supprimer.php?id=<?= $s['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette spécialité ?')"><i class="fa-solid fa-trash"></i></a>
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
