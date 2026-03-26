<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// On vérifie si un identifiant (id) a été passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // On supprime la recommandation
    $req = $bdd->prepare('DELETE FROM recomendation WHERE id = ?');
    $req->execute([$id]);
}

// Redirection
header('Location: liste.php');
die;
