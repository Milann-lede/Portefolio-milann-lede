<?php
// Connexion BDD (session non requise — page publique)
require '../php/header.php';

// Récupère les textes de la table contenu et les stocke dans un tableau [identifient => contenu]
$rows = $bdd->query('SELECT * FROM contenu')->fetchAll();
$textes = [];
foreach ($rows as $r) {
    // La clé du tableau = identifiant de la section, la valeur = le texte
    $textes[$r['identifient']] = $r['contenu'];
}

// Récupère les compétences triées par ordre d'affichage
$result = $bdd->query('SELECT * FROM mes_competences ORDER BY ordre ASC');
$competences = $result->fetchAll();

// Récupère le parcours trié par ordre d'affichage
$result2 = $bdd->query('SELECT * FROM mon_parcours ORDER BY ordre ASC');
$parcours = $result2->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>À propos de moi — Milann</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../style/styles.css" />
  <link rel="stylesheet" href="../style/a-propos.css" />

</head>

<body>

  <!-- Header / Nav -->
  <header class="header">
    <div class="container nav-wrap">
      <a href="#hero" class="logo">Mon<span>Portfolio</span></a>

      <nav class="nav" id="nav">
        <a href="../../index.php" class="nav-link">Accueil</a>
        <a href="./a-propos.php" class="nav-link">À propos de moi</a>
        <a href="./projets.php" class="nav-link">Projets</a>
        <a href="./recomendation.php" class="nav-link">recomendation</a>
        <a href="./contact.php" class="btn primary">Contact</a>
      </nav>

      <!-- Photo de profil -->
      <div class="profile-pic-wrap">
        <img src="../image/photo-de-milann-lede.jpeg" alt="Photo de Milann Lédé" class="profile-pic">
      </div>

      <button class="burger" id="burger" aria-label="Ouvrir le menu">
        <span></span><span></span><span></span>
      </button>
    </div>

  </header>

  <section id="hero" class="hero section">
    <br>
    <div class="container grid-2">
      <div class="hero-copy">
        <h1 class="title">Salut, moi c'est <span class="gradient">Milann </span> étudiant en <span
            class="gradient">développement web</span>
        </h1>
        <p class="lead">
          Je crée des sites modernes, esthétiques et performants en <strong>HTML</strong>, <strong>CSS</strong> et
          <strong>JavaScript</strong>.
        </p>
      </div>
      <?php
      // Récupère les 6 spécialités les plus élevées depuis la BDD
      $result      = $bdd->query('SELECT * FROM Specialise ORDER BY pourcentage DESC LIMIT 6');
      $specialites = $result->fetchAll();
      ?>
      <div class="hero-art">
        <div class="card-3d reveal">
          <div class="card-3d__inner">
            <h3 class="titre-header">Spécialisé en</h3>
            <div class="tech-logos">
              <?php foreach ($specialites as $s): ?>
                <div class="tech-logo-item">
                  <?php if ($s['img'] === 'vscode'): ?>
                    <svg class="tech-icon fa-vscode" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor">
                      <path d="M23.15 2.587L18.21.21a1.494 1.494 0 0 0-1.705.29l-9.46 8.63-4.12-3.128a.999.999 0 0 0-1.276.057L.327 7.261A1 1 0 0 0 .326 8.74L3.899 12 .326 15.26a1 1 0 0 0 .001 1.479L1.65 17.94a.999.999 0 0 0 1.276.057l4.12-3.128 9.46 8.63a1.492 1.492 0 0 0 1.704.29l4.942-2.377A1.5 1.5 0 0 0 24 20.06V3.939a1.5 1.5 0 0 0-.85-1.352zm-5.146 14.861L10.826 12l7.178-5.448v10.896z"/>
                    </svg>
                  <?php elseif (substr($s['img'], 0, 3) === 'fa-'): ?>
                    <i class="<?= $s['img'] ?> tech-icon"></i>
                  <?php else: ?>
                    <img src="../image/<?= $s['img'] ?>" class="tech-icon" style="width:7.5rem;height:7.5rem;object-fit:contain">
                  <?php endif; ?>
                  <p class="gradient"><?= $s['nom'] ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about">
    <h1>À propos de moi</h1>
    <p class="subtitle">Mon parcours, mes compétences et ce qui me passionne.</p>

    <div class="timeline">

      <!-- Bloc "Qui je suis" -->
      <div class="timeline-row">
        <div class="timeline-col left">
          <div class="content">
            <h2>Qui je suis</h2>
            <!-- nl2br() convertit les sauts de ligne (\n) en balises <br> pour l'affichage HTML -->
            <!-- ?? '' retourne une chaîne vide si la clé n'existe pas dans le tableau -->
            <p><?= nl2br($textes['Qui je suis'] ?? '') ?></p>
          </div>
        </div>
        <div class="timeline-icon">
          <i class="fa-regular fa-user"></i>
        </div>
        <div class="timeline-col right"></div>
      </div>

      <!-- Bloc "Mon Parcours" -->
      <div class="timeline-row">
        <div class="timeline-col left"></div>
        <div class="timeline-icon">
          <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="timeline-col right">
          <div class="content">
            <h2>Mon Parcours</h2>
            <ul>
              <?php foreach ($parcours as $p): // Boucle : affiche chaque entrée du parcours ?>
              <li>
                <!-- Affiche la date/établissement en gras -->
                <strong><?= $p['date'] ?></strong><br>
                <!-- nl2br() pour conserver les sauts de ligne saisis dans l'admin -->
                <?= nl2br($p['info']) ?>
              </li>
              <?php endforeach; // Fin boucle parcours ?>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bloc "Mes compétences" -->
      <div class="timeline-row">
        <div class="timeline-col left">
          <div class="content">
            <h2>Mes compétences</h2>
            <div class="skills-container">
              <?php foreach ($competences as $comp): // Boucle : affiche chaque compétence avec sa barre de niveau ?>
              <div class="skill-item">
                <div class="skill-info">
                  <!-- Affiche le nom de la compétence -->
                  <span class="skill-name"><?= $comp['nom'] ?></span>
                  <!-- Affiche le pourcentage -->
                  <span class="skill-percentage"><?= $comp['pourcentage'] ?>%</span>
                </div>
                <div class="skill-bar">
                  <!-- La largeur de la barre CSS = le pourcentage stocké en BDD -->
                  <div class="skill-progress" style="width: <?= $comp['pourcentage'] ?>%;"></div>
                </div>
              </div>
              <?php endforeach; // Fin boucle compétences ?>
            </div>
          </div>
        </div>
        <div class="timeline-icon">
          <i class="fa-solid fa-laptop"></i>
        </div>
        <div class="timeline-col right"></div>
      </div>

      <!-- Bloc "Mes hobbies" -->
      <div class="timeline-row">
        <div class="timeline-col left"></div>
        <div class="timeline-icon">
          <i class="fa-regular fa-heart"></i>
        </div>
        <div class="timeline-col right">
          <div class="content">
            <h2>Mes hobbies</h2>
            <!-- Affiche le texte des hobbies depuis la BDD, ?? '' évite une erreur si vide -->
            <p><?= nl2br($textes['Mes hobbies'] ?? '') ?></p>
          </div>
        </div>
      </div>

      <!-- Bloc "Mon CV" -->
      <div class="timeline-row">
        <div class="timeline-col left">
          <div class="content">
            <h2>Mon CV</h2>
            <p class="mb-1">Pour un aperçu complet de mon parcours, n'hésitez pas à télécharger mon CV.</p>
            <a href="../image/CV_milann_lede_portfolio.pdf" download="CV_milann_lede_portfolio.pdf" class="btn">
              <i class="fa-solid fa-download"></i>
              Télécharger mon CV
            </a>
          </div>
        </div>
        <div class="timeline-icon">
          <i class="fa-regular fa-file"></i>
        </div>
        <div class="timeline-col right"></div>
      </div>

    </div>
  </section>


  <!-- Footer -->
  <footer class="footer">
    <div class="container footer-container">
      <p class="footer-text">© 2025 — Portfolio de Milann</p>
    </div>
  </footer>

  <script src="../js/script.js"></script>

<!-- SiteHub Analytics — GDPR Compliant -->
<script src="http://localhost:3006/consent.js"></script>
<script src="http://localhost:3006/tracker.js" data-site-id="cmljmoygt000bp4gpnr58cru9" data-endpoint="http://localhost:3006/api/analytics/collect"></script>
</body>

</html>
