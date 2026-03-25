<?php
// Connexion BDD 
require '../php/header.php';

// Variable pour afficher un message de retour après l'envoi du formulaire
$message_retour = '';

// Traitement du formulaire si l'utilisateur l'a soumis 
if (isset($_POST['name'])) {

    // Nettoie les données reçues
    $nom     = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Vérifie que tous les champs sont remplis avant d'insérer
    if (!empty($nom) && !empty($email) && !empty($message)) {

        // Insère le message en BDD avec une requête préparée 
        $req = $bdd->prepare('INSERT INTO messages_contact (nom, email, message) VALUES (?, ?, ?)');
        $req->execute([$nom, $email, $message]);

        // Message de confirmation affiché sous le formulaire
        $message_retour = '<p style="color:green">Message envoyé !</p>';

    } else {
        // Message d'erreur si un champ est vide
        $message_retour = '<p style="color:red">Merci de remplir tous les champs.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact — Milann</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- EmailJS SDK -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

    <link rel="stylesheet" href="../style/styles.css" />
    <link rel="stylesheet" href="../style/contact.css" />
</head>

<body>

    <!-- Header / Nav -->
    <header class="header">
        <div class="container nav-wrap">
            <a href="../../index.html" class="logo">Mon<span>Portfolio</span></a>

            <nav class="nav" id="nav">
                <a href="../../index.php" class="nav-link">Accueil</a>
                <a href="./a-propos.php" class="nav-link">À propos de moi</a>
                <a href="./projets.php" class="nav-link">Projets</a>
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
                    Je crée des sites modernes, esthétiques et performants en <strong>HTML</strong>,
                    <strong>CSS</strong> et
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



    <!-- Hero Contact -->
    <section class="section">
        <div class="container">
            <h1 class="title">Me <span class="gradient">contacter</span></h1>
            <p class="lead">Vous avez un projet ? Discutons-en !</p>
        </div>
    </section>



    <!-- Contact Grid -->
    <section id="contact-main" class="section">
        <div class="container grid-2 contact-grid">
            <!-- Contact Info Card -->
            <div class="card contact-info contact-info-card">
                <h2 class="section-title contact-section-title">Mes <span class="gradient">coordonnées</span></h2>
                <ul class="coords contact-coords">
                    <li>
                        <strong>Email :</strong><br>
                        <a href="mailto:Milann.lede@icloud.com">Milann.lede@icloud.com</a>
                    </li>
                    <li>
                        <strong>Téléphone :</strong><br>
                        <a href="tel:+330749522451">+33 07 49 52 24 51</a>
                    </li>
                    <li>
                        <strong>GitHub :</strong><br>
                        <a href="https://github.com/Milann-lede" target="_blank">github.com/Milann-lede</a>
                    </li>
                    <li>
                        <strong>LinkedIn :</strong><br>
                        <a href="https://www.linkedin.com/in/milann-lede/"
                            target="_blank">linkedin.com/in/milann-lede</a>
                    </li>
                </ul>
            </div>

            <!-- Formulaire -->
            <form id="contact-form" class="contact-form" method="POST" action="">
                <h2 class="section-title contact-form-title">Envoyer un <span class="gradient">message</span></h2>
                <div class="form-row">
                    <label for="name">Nom</label>
                    <input id="name" name="name" type="text" required placeholder="Votre nom" />
                </div>

                <div class="form-row">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required placeholder="votre@email.com" />
                </div>

                <div class="form-row">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required
                        placeholder="Bonjour, j'aimerais..."></textarea>
                </div>

                <button class="btn primary" type="submit">Envoyer</button>
                <?php echo $message_retour; // Affiche le message de succès ou d'erreur ?>
            </form>
        </div>
    </section>



    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-container">
            <p class="footer-text">© 2025 — Portfolio de Milann</p>
        </div>
    </footer>

    <!-- Script pour le menu burger et le formulaire -->
    <script src="../js/script.js"></script>


<!-- SiteHub Analytics — GDPR Compliant -->
<script src="http://localhost:3006/consent.js"></script>
<script src="http://localhost:3006/tracker.js" data-site-id="cmljmoygt000bp4gpnr58cru9" data-endpoint="http://localhost:3006/api/analytics/collect"></script>
</body>

</html>
