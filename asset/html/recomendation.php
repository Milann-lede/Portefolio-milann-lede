<?php
require '../php/header.php';

$message_retour = '';

// Traitement du formulaire de soumission
if (isset($_POST['nom'])) {
    $req = $bdd->prepare('INSERT INTO recomendation (nom, entreprise, text) VALUES (?, ?, ?)');
    $req->execute([$_POST['nom'], $_POST['entreprise'], $_POST['text']]);
    $message_retour = 'success';

    header("Location: recomendation.php");
    die;
}

// Récupère toutes les recommandations validées
$result = $bdd->query('SELECT * FROM recomendation WHERE valide = 1 ORDER BY ordre ASC');
$recomendations = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recommandations — Milann</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style/styles.css" />
</head>
<body>

    <header class="header">
        <div class="container nav-wrap">
            <a href="../../index.php" class="logo">Mon<span>Portfolio</span></a>
            <nav class="nav" id="nav">
                <a href="../../index.php" class="nav-link">Accueil</a>
                <a href="./a-propos.php" class="nav-link">À propos de moi</a>
                <a href="./projets.php" class="nav-link">Projets</a>
                <a href="./recomendation.php" class="nav-link active">Recommandations</a>
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

    <!-- Recommandations validées -->
    <section class="section">
        <div class="container">
            <h1 class="title">Ce qu'ils disent de <span class="gradient">moi</span></h1>
            <p class="lead">Les avis de personnes avec qui j'ai eu la chance de collaborer.</p>

            <div class="reco-grid">
                <?php foreach ($recomendations as $r): ?>
                    <div class="reco-card">
                        <p>« <?= $r['text'] ?> »</p>
                        <b><?= $r['nom'] ?></b> — <?= $r['entreprise'] ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (empty($recomendations)) echo "Aucune recommandation pour l'instant."; ?>
        </div>
    </section>

    <!-- Formulaire de soumission -->
    <section class="section">
        <div class="container">
            <h2 class="title" style="font-size:1.8rem">Laisser une <span class="gradient">recommandation</span></h2>
            <p class="lead">Elle sera visible après validation de ma part.</p>

            <form class="reco-form" method="POST" action="">
                <div class="form-row">
                    <label for="nom">Nom *</label>
                    <input id="nom" name="nom" type="text" required placeholder="Votre nom" />
                </div>
                <div class="form-row">
                    <label for="entreprise">Entreprise / Établissement</label>
                    <input id="entreprise" name="entreprise" type="text" placeholder="Votre entreprise (optionnel)" />
                </div>
                <div class="form-row">
                    <label for="text">Message *</label>
                    <textarea id="text" name="text" rows="5" required placeholder="Votre recommandation..."></textarea>
                </div>
                <button class="btn primary" type="submit">Envoyer</button>
                <?php if ($message_retour === 'success'): ?>
                    <p class="msg-success"><i class="fa-solid fa-check"></i> Merci ! Ta recommandation est en attente de validation.</p>
                <?php elseif ($message_retour === 'error'): ?>
                    <p class="msg-error">Merci de remplir au moins ton nom et ton message.</p>
                <?php endif; ?>
            </form>
        </div>
    </section>

    <footer class="footer">
        <div class="container footer-container">
            <p class="footer-text">© 2025 — Portfolio de Milann</p>
        </div>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
