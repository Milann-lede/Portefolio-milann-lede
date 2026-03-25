<?php
// Démarre la session PHP (nécessaire pour garder l'utilisateur connecté)
session_start();

// Connexion à la base de données MySQL via PDO
$bdd = new PDO('mysql:host=localhost:8889;dbname=cv;charset=utf8', 'root', 'root');
