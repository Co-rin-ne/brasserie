<?php
require 'db.php';
session_start();

// Vérifie que l'utilisateur est un caissier
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'caissier') {
    header("Location: erreur.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $commande_id = $_POST['commande_id'];
    $client_id = $_POST['client_id'];
    $points = (int)$_POST['points'];

    try {
        // 1. Mettre à jour le statut de la commande comme "payée"
        $update = $pdo->prepare("UPDATE commandes SET statut = 'payée' WHERE id = ?");
        $update->execute([$commande_id]);

        // 2. Ajouter les points fidélité au client
        $update_points = $pdo->prepare("UPDATE utilisateurs SET points_fidelite = points_fidelite + ? WHERE id = ?");
        $update_points->execute([$points, $client_id]);

        header("Location: caissier_dashboard.php?success=commande_validee");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "⛔ Requête invalide.";
}
