<?php
// Connexion BDD (page publique)
require '../php/header.php';

$ch = curl_init('https://api.github.com/users/milann-lede/repos');
$header = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
curl_setopt($ch, CURLOPT_USERAGENT, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$projetsGit = json_decode($result, true);

// Requête SQL : récupère tous les projets avec leur catégorie (LEFT JOIN = lien entre les tables)
$result = $bdd->query('
    SELECT p.*, c.name AS categorie
    FROM projet p
    LEFT JOIN projet_categorie pc ON pc.id_projet = p.id
    LEFT JOIN categorie c ON c.id = pc.id_categorie
');
// Stocke tous les résultats dans un tableau associatif
$projets = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mes Projets — Milann</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../style/styles.css" />
    <link rel="stylesheet" href="../style/projets.css" />
</head>


<body>

    <header class="header">
        <div class="container nav-wrap">
            <a href="../../index.php" class="logo">Mon<span>Portfolio</span></a>

            <nav class="nav" id="nav">
                <a href="../../index.php" class="nav-link">Accueil</a>
                <a href="./a-propos.php" class="nav-link">À propos de moi</a>
                <a href="./projets.php" class="nav-link active">Projets</a>
                <a href="./recomendation.php" class="nav-link">recomendation</a>
                <a href="./contact.php" class="btn primary">Contact</a>
            </nav>

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

    <main>
        <section class="section projects-section">
            <div class="container">
                <h1 class="section-title">Mes <span class="gradient">projets</span></h1>

                <div class="filter-bar">
                    <button class="filter-btn active" data-filter="all">Tous</button>
                    <button class="filter-btn" data-filter="scolaire">Scolaire</button>
                    <button class="filter-btn" data-filter="perso">Personnel</button>
                    <button class="filter-btn" data-filter="stage">Stage</button>
                    <button class="filter-btn" data-filter="ia">IA</button>
                    <button class="filter-btn" data-filter="github"><i class="fa-brands fa-github"></i> GitHub</button>
                </div>

                <div class="projects-grid-page"></div>

                <div id="github-repos" style="display:none">
                    <?php foreach ($projetsGit ?? [] as $projet): ?>
                    <a class="github-repo-card" href="<?= htmlspecialchars($projet['html_url']) ?>" target="_blank" rel="noopener noreferrer">
                        <span class="github-repo-name"><?= htmlspecialchars($projet['full_name']) ?></span>
                        <span class="github-repo-date"><?= date('d/m/Y', strtotime($projet['created_at'])) ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <div id="project-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-body"></div>
        </div>
    </div>

    <footer class="footer">
        <div class="container footer-container">
            <p class="footer-text">© 2025 — Portfolio de Milann</p>
        </div>
    </footer>

    <script src="../js/script.js"></script>
    <script src="../js/projets.js"></script>
    

    <!-- Injecte les projets BDD après que projets.js ait déclaré defaultProjects -->
    <script>
        const projetsDB = <?= json_encode(array_map(function($p) {
            return [
                'id'          => (int)$p['id'],
                'title'       => $p['name'],
                'category'    => $p['categorie'] ?? '',
                'image'       => '../image/' . $p['img'],
                'role'        => $p['mon_role'] ?? '',
                'context'     => $p['Contexte'] ?? '',
                'tools'       => $p['outils'] ?? '',
                'stack'       => $p['stack_technique'] ?? '',
                'duration'    => $p['duree'] ?? '',
                'description' => $p['info'] ?? '',
                'link'        => $p['lien_site'] ?? '',
                'shortDesc'   => $p['info'] ?? '',
                'featured'    => false,
                'archived'    => false,
            ];
        }, $projets)) ?>;

        // On mute le tableau const (possible) sans le redéclarer
        defaultProjects.length = 0;
        projetsDB.forEach(p => defaultProjects.push(p));

        // Re-render avec les données BDD
        displayProjects(defaultProjects);
    </script>

</body>

</html>
