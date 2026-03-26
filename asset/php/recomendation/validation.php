<?php
// Connexion BDD + démarrage de session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// On vérifie si un identifiant (id) a été passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // On met à jour la ligne correspondante dans la base de données 
    // en passant la colonne `valide` à 1 (vrai)
    $req = $bdd->prepare('UPDATE recomendation SET valide = 1 WHERE id = ?');
    $req->execute([$id]);
}

// Une fois fait, on redirige l'utilisateur vers la liste des recommandations
header('Location: liste.php');
die;
