<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Récupère les catégories pour le menu déroulant
$result     = $bdd->query('SELECT * FROM categorie');
$categories = $result->fetchAll();

// Traitement du formulaire quand il est soumis (méthode POST)
if (isset($_POST['name'])) {

    // Récupère le nom du fichier uploadé et le déplace dans le dossier image/
    $nomImg = $_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'], '../../image/' . $nomImg);

    // INSERT INTO avec requête préparée (les ? sont remplacés par les valeurs de execute)
    $req = $bdd->prepare('INSERT INTO projet (name, mon_role, Contexte, outils, stack_technique, duree, info, img, lien_site) VALUES (?,?,?,?,?,?,?,?,?)');
    $req->execute([$_POST['name'], $_POST['mon_role'], $_POST['Contexte'], $_POST['outils'], $_POST['stack_technique'], $_POST['duree'], $_POST['info'], $nomImg, $_POST['lien_site']]);

    // lastInsertId() retourne l'id du projet qu'on vient d'insérer — pour créer la liaison catégorie
    $req = $bdd->prepare('INSERT INTO projet_categorie (id_categorie, id_projet) VALUES (?,?)');
    $req->execute([$_POST['id_categorie'], $bdd->lastInsertId()]);

    header('location:liste.php'); 
    die;
  }


$pageTitle  = 'Ajouter un projet';
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

<a href="liste.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Retour aux projets</a>
<div class="page-header"><h1>Ajouter un projet</h1></div>

<?php // enctype="multipart/form-data" est obligatoire pour envoyer un fichier ?>
<form method="POST" enctype="multipart/form-data">
  <div class="form-card">
    <div class="form-group"><label>Nom du projet</label><input type="text" name="name" required autofocus placeholder="Mon super projet"></div>
    <div class="form-group"><label>Mon rôle</label><input type="text" name="mon_role" placeholder="Développeur front-end"></div>
    <div class="form-group"><label>Contexte</label><textarea name="Contexte" placeholder="Description du contexte..."></textarea></div>
    <div class="form-group"><label>Outils</label><input type="text" name="outils" placeholder="VS Code, Figma..."></div>
    <div class="form-group"><label>Stack technique</label><input type="text" name="stack_technique" placeholder="HTML, CSS, PHP..."></div>
    <div class="form-group"><label>Durée</label><input type="text" name="duree" placeholder="2 semaines"></div>
    <div class="form-group"><label>Description</label><textarea name="info" placeholder="Détails sur le projet..."></textarea></div>
    <div class="form-group"><label>Image du projet</label><input type="file" name="img" accept="image/*"></div>
    <div class="form-group"><label>Lien du site</label><input type="url" name="lien_site" placeholder="https://..."></div>
    <div class="form-group">
      <label>Catégorie</label>
      <select name="id_categorie">
        <?php foreach ($categories as $cat): // Boucle : une option par catégorie ?>
          <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Ajouter</button>
      <a href="liste.php" class="btn btn-ghost">Annuler</a>
    </div>
  </div>
</form>

    </div>
  </main>
</div>
</body>
</html>
