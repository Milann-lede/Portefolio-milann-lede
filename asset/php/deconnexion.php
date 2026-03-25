<?php
// Démarre la session puis la détruit pour déconnecter l'utilisateur
    require 'header.php';

    session_destroy();

    header('location: login.php'); 
    die;
