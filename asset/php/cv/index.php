<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Chemin absolu vers le fichier CV sur le serveur
$cvPath   = realpath(__DIR__ . '/../../image') . '/CV_milann_lede_portfolio.pdf';
// file_exists() vérifie si le fichier existe sur le serveur
$cvExists = file_exists($cvPath);
$message  = '';
$erreur   = '';

// Traitement de l'upload du nouveau CV
if (isset($_POST['upload'])) {
    $fichier = $_FILES['cv'] ?? null;

    // $_FILES['cv']['error'] !== UPLOAD_ERR_OK = une erreur s'est produite pendant l'upload
    if (!$fichier || $fichier['error'] !== UPLOAD_ERR_OK) {
        $erreur = 'Erreur lors de l\'upload (code ' . ($fichier['error'] ?? '?') . ').';
    } else {
        // finfo vérifie le vrai type MIME du fichier (plus fiable que l'extension)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $fichier['tmp_name']);
        finfo_close($finfo);

        if ($mime !== 'application/pdf') {
            $erreur = 'Le fichier n\'est pas un PDF valide (détecté : ' . $mime . ').';
        } else {
            // unlink() supprime l'ancien fichier avant de le remplacer
            if (file_exists($cvPath)) unlink($cvPath);
            // move_uploaded_file() déplace le fichier temporaire vers son emplacement définitif
            if (move_uploaded_file($fichier['tmp_name'], $cvPath)) {
                $message  = 'CV mis à jour avec succès.';
                $cvExists = true;
            } else {
                $erreur = 'Échec de l\'enregistrement. Vérifie les permissions du dossier image/.';
            }
        }
    }
}

$pageTitle  = 'Mon CV';
$activePage = 'cv';
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

  <div class="page-header"><h1>Mon CV</h1></div>

  <?php if ($message): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> <?= $message ?></div>
  <?php endif; ?>

  <?php if ($erreur): ?>
    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= $erreur ?></div>
  <?php endif; ?>

  <?php if ($cvExists): // Si le fichier CV existe sur le serveur ?>
    <div class="cv-card">
      <div class="cv-meta">
        <p>Fichier : <strong>CV_milann_lede_portfolio.pdf</strong></p>
        <p>Taille : <strong><?= round(filesize($cvPath) / 1024) ?> Ko</strong></p>
        <p>Modifié le : <strong><?= date('d/m/Y à H:i', filemtime($cvPath)) ?></strong></p>
      </div>
      <a href="../../image/CV_milann_lede_portfolio.pdf?v=<?= filemtime($cvPath) ?>" target="_blank" class="btn btn-secondary">
        <i class="fa-regular fa-eye"></i> Voir le CV
      </a>
    </div>
  <?php else: ?>
    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> Aucun CV trouvé dans image/.</div>
  <?php endif; ?>

  <div class="form-card">
    <p style="color:var(--muted2);font-size:.875rem;margin-bottom:1.25rem">Remplacer le CV par un nouveau fichier PDF (max 5 Mo).</p>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Nouveau fichier PDF</label>
        <input type="file" name="cv" accept="application/pdf" required>
      </div>
      <div class="form-actions">
        <button type="submit" name="upload" class="btn btn-primary">
          <i class="fa-solid fa-upload"></i> Mettre à jour
        </button>
      </div>
    </form>
  </div>

    </div>
  </main>
</div>
</body>
</html>
