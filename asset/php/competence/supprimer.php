<?php
// Connexion BDD + session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Supprime la compétence et redirige vers la liste
$req = $bdd->prepare('DELETE FROM mes_competences WHERE id = ?');
$req->execute([$_GET['id']]);

header('location:liste.php'); die;
?>
