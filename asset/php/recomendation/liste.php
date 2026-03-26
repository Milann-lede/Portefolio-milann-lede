<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Récupère toutes les recommandations, en attente d'abord
$result         = $bdd->query('SELECT * FROM recomendation ORDER BY valide ASC, ordre ASC');
$recomendations = $result->fetchAll();

$pageTitle  = 'Recommandations';
$activePage = 'recomendation';
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
    <h1>Recommandations</h1>
    <span style="color:var(--muted2);font-size:.9rem"><?= count($recomendations) ?> au total</span>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Nom</th><th>Entreprise</th><th>Message</th><th>Statut</th><th>Actions</th></tr>
      </thead>

      <tbody id="sortable">
        <?php foreach ($recomendations as $r): ?>
          <tr id="<?= $r['id'] ?>" data-id="<?= $r['id'] ?>">
            <td><strong><?= $r['nom'] ?></strong></td>
            <td><?= $r['entreprise'] ?></td>
            <td class="td-truncate"><?= $r['text'] ?></td>
            <td>
              <?php if ($r['valide']): ?>
                <span style="color:#22c55e;font-weight:600"><i class="fa-solid fa-circle-check"></i> Validé</span>
              <?php else: ?>
                <span style="color:#f59e0b;font-weight:600"><i class="fa-solid fa-clock"></i> En attente</span>
              <?php endif; ?>
            </td>

            <td>
              <?php if (!$r['valide']): ?>
                <a href="validation.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-ghost" style="color:#22c55e;">Valider</a> 
              <?php endif; ?>
              <a href="supprimer.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-ghost" style="color:#ef4444;">Supprimer</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($recomendations)): ?>
          <tr><td colspan="5" style="text-align:center;color:var(--muted2);padding:2rem">Aucune recommandation reçue.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

    </div>
  </main>
</div>

<script src="../../js/Sortable-1.15.7/Sortable.min.js"></script>
<script>
  var el = document.getElementById('sortable');
  if (el) {
    var sortable = Sortable.create(el, {
      animation: 150,
      onEnd: function (evt) {
        console.log("Ancien index:", evt.oldIndex);
        console.log("Nouvel index:", evt.newIndex);

        fetch("ajax.php?action=change_ordrerecomendation", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            oldIndex: evt.oldIndex,
            newIndex: evt.newIndex
          })
        });
      }
    });
  }
</script>
</body>
</html>
