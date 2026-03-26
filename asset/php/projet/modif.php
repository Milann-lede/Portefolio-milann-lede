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

// Récupère le projet à modifier
$req = $bdd->prepare('SELECT * FROM projet WHERE id = ?');
$req->execute([$id]);
$projet = $req->fetch(); // fetch() récupère une seule ligne

// Récupère les catégories pour le menu déroulant
$result     = $bdd->query('SELECT * FROM categorie');
$categories = $result->fetchAll();

// Récupère la catégorie actuelle du projet (pour la pré-sélectionner dans le <select>)
$req = $bdd->prepare('SELECT id_categorie FROM projet_categorie WHERE id_projet = ?');
$req->execute([$id]);
$categorieActuelle = $req->fetch()['id_categorie'];

// Traitement du formulaire de modification
if (isset($_POST['name'])) {

    // Par défaut, on garde l'ancienne image
    $nomImg = $projet['img'];
    // error === 0 = un fichier a bien été envoyé sans erreur
    if ($_FILES['img']['error'] === 0) {
        $nomImg = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], '../../image/' . $nomImg);
    }

    // UPDATE modifie les données en BDD. Sans WHERE on modifierait TOUS les projets !
    $req = $bdd->prepare('UPDATE projet SET name=?, mon_role=?, Contexte=?, outils=?, stack_technique=?, duree=?, info=?, img=?, lien_site=? WHERE id=?');
    $req->execute([$_POST['name'], $_POST['mon_role'], $_POST['Contexte'], $_POST['outils'], $_POST['stack_technique'], $_POST['duree'], $_POST['info'], $nomImg, $_POST['lien_site'], $id]);

    // Met à jour la catégorie liée au projet
    $req = $bdd->prepare('UPDATE projet_categorie SET id_categorie=? WHERE id_projet=?');
    $req->execute([$_POST['id_categorie'], $id]);

    header('location:liste.php'); die;
}

$pageTitle  = 'Modifier un projet';
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
<div class="page-header"><h1>Modifier — <?= $projet['name'] ?></h1></div>

<?php // enctype="multipart/form-data" obligatoire pour envoyer un fichier ?>
<form method="POST" enctype="multipart/form-data">
  <div class="form-card">
    <?php // Champ caché : transmet l'id du projet via POST sans l'afficher ?>
    <input type="hidden" name="id" value="<?= $projet['id'] ?>">
    <?php // value="..." pré-remplit chaque champ avec la valeur actuelle en BDD ?>
    <div class="form-group"><label>Nom du projet</label><input type="text" name="name" value="<?= $projet['name'] ?>" required></div>
    <div class="form-group"><label>Mon rôle</label><input type="text" name="mon_role" value="<?= $projet['mon_role'] ?>"></div>
    <div class="form-group"><label>Contexte</label><textarea name="Contexte"><?= $projet['Contexte'] ?></textarea></div>
    <div class="form-group"><label>Outils</label><input type="text" name="outils" value="<?= $projet['outils'] ?>"></div>
    <div class="form-group"><label>Stack technique</label><input type="text" name="stack_technique" value="<?= $projet['stack_technique'] ?>"></div>
    <div class="form-group"><label>Durée</label><input type="text" name="duree" value="<?= $projet['duree'] ?>"></div>
    <div class="form-group"><label>Description</label><textarea name="info"><?= $projet['info'] ?></textarea></div>
    <div class="form-group">
      <label>Nouvelle image <span style="font-weight:400;text-transform:none;font-size:.8rem;color:var(--muted2)">(laisser vide pour garder l'actuelle)</span></label>
      <input type="file" name="img" accept="image/*">
    </div>
    <div class="form-group"><label>Lien du site</label><input type="url" name="lien_site" value="<?= $projet['lien_site'] ?>"></div>
    <div class="form-group">
      <label>Catégorie</label>
      <select name="id_categorie">
        <?php foreach ($categories as $cat): // Boucle : une option par catégorie ?>
          <?php // "selected" est ajouté si c'est la catégorie actuelle du projet ?>
          <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $categorieActuelle ? 'selected' : '' ?>><?= $cat['name'] ?></option>
        <?php endforeach; ?>
      </select>
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
