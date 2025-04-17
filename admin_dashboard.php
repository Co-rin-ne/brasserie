<?php
require 'db.php';
session_start();

// Vérification si l'utilisateur est un admin
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: erreur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1d4;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #c1911f;
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .dashboard-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
        }

        .dashboard-card a {
            text-decoration: none;
            color: #c1911f;
            font-weight: bold;
            font-size: 18px;
            display: block;
        }

        .dashboard-card a:hover {
            color: #a37919;
        }

        /* Style du bouton Logs */
        .log-button {
            background: #c1911f;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
        }

        .log-button:hover {
            background: black;
            color: #f8f1d4;
        }

        .logout {
            margin-top: 30px;
        }

        .logout a {
            color: red;
            font-weight: bold;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>👑 Tableau de Bord Administrateur</h1>

<div class="dashboard-container">
    <div class="dashboard-card">
        <a href="ajoutez_point.php">🛠️ Gestion des Points de Fidélité</a>
    </div>
    <div class="dashboard-card">
        <a href="admin.php">👥 Gestion des Utilisateurs</a>
    </div>
</div>

<!-- 🚀 Bouton pour voir les logs -->
<a href="/logs/logs.php" class="log-button">📜 Voir les Logs</a>

<div class="logout">
    <a href="logout.php">🚪 Déconnexion</a>
</div>

</body>
</html>
