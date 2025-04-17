<?php

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou de connexion
header("Location: index.php"); // ou "login.php" selon ce que tu préfères
exit();
?>
