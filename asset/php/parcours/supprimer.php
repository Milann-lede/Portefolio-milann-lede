<?php
// Connexion BDD + session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Supprime l'entrée du parcours et redirige vers la liste
if (!empty($_GET['id'])) {
    $req = $bdd->prepare('DELETE FROM mon_parcours WHERE id = ?');
    $req->execute([$_GET['id']]);
}

header('location:liste.php'); die;
