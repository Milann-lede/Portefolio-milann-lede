<?php
// Connexion BDD + démarrage de session
require '../header.php';

// Redirige vers login si l'utilisateur n'est pas connecté
if (!isset($_SESSION['conecter'])) {
    header('location:../login.php');
    die;
}

// Récupère tous les projets depuis la BDD
$result = $bdd->query('SELECT * FROM projet');
$projets = $result->fetchAll();

// Titre de la page et lien actif dans la sidebar
$pageTitle  = 'Mes projets';
$activePage = 'projets';
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

  <!-- Sidebar de navigation -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <strong>Mon<span>Portfolio</span></strong>
      <small>Espace admin</small>
    </div>
    <nav class="sidebar-nav">
      <?php // Condition ternaire : ajoute la classe "active" si c'est la page courante ?>
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

  <!-- Contenu principal -->
  <main class="admin-main">
    <div class="admin-topbar">
      <span class="topbar-title"><?= $pageTitle ?></span>
      <div class="topbar-right"><a href="../../../index.php" target="_blank">Voir le portfolio →</a></div>
    </div>
    <div class="admin-content">

<div class="page-header">
  <h1>Mes projets</h1>
  <a href="ajout.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Ajouter un projet</a>
</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>Image</th><th>Nom</th><th>Mon rôle</th><th>Stack</th><th>Durée</th><th>Lien</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($projets as $p): // Boucle : une ligne par projet ?>
        <tr>
          <td>
            <?php // Affiche l'image du projet depuis le dossier image/ ?>
            <img src="../../../asset/image/<?= $p['img'] ?>" width="60" height="45">
          </td>
          <td><strong><?= $p['name'] ?></strong></td>
          <td class="td-truncate"><?= $p['mon_role'] ?></td>
          <td class="td-truncate"><?= $p['stack_technique'] ?></td>
          <td><?= $p['duree'] ?></td>
          <td>
            <?php if ($p['lien_site']): // Si un lien est renseigné ?>
              <a href="<?= $p['lien_site'] ?>" target="_blank" class="btn btn-ghost btn-sm">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Voir
              </a>
            <?php else: // Sinon affiche un tiret ?>
              <span style="color:var(--muted2);font-size:.8rem">—</span>
            <?php endif; ?>
          </td>
          <td>
            <div class="actions-cell">
              <?php // Passe l'id du projet dans l'URL (méthode GET) ?>
              <a href="modif.php?id=<?= $p['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-pen"></i> Modifier</a>
              <?php // confirm() affiche une popup JavaScript avant de supprimer ?>
              <a href="supprimer.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce projet ?')"><i class="fa-solid fa-trash"></i></a>
            </div>
          </td>
        </tr>
      <?php endforeach; // Fin de la boucle foreach ?>

    </tbody>
  </table>
</div>

    </div>
  </main>
</div>
</body>
</html>
