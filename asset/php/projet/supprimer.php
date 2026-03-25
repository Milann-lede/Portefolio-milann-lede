<?php
// Connexion BDD + session
require '../header.php';

// Redirige vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['conecter'])) {
    header('location:../login.php');
    die;
}

// Récupère l'id du projet passé dans l'URL (ex: supprimer.php?id=5)
$id = $_GET['id'];

// Supprime d'abord la liaison projet <-> catégorie (sinon erreur de clé étrangère)
$req = $bdd->prepare('DELETE FROM projet_categorie WHERE id_projet = ?');
$req->execute([$id]);

// Supprime ensuite le projet lui-même
$req = $bdd->prepare('DELETE FROM projet WHERE id = ?');
$req->execute([$id]);

// Redirige vers la liste une fois la suppression effectuée
header('location:liste.php');
die;
?>
