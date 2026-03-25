<?php
// Connexion BDD + session
require '../header.php';
if (!isset($_SESSION['conecter'])) { header('location:../login.php'); die; }

// Supprime la spécialité et redirige vers la liste
$req = $bdd->prepare('DELETE FROM Specialise WHERE id = ?');
$req->execute([$_GET['id']]);

header('location:liste.php'); die;
?>
