<?php
require 'db.php';
session_start();

// Vérifier que l'utilisateur est caissier
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'caissier') {
    header("Location: login.php");
    exit();
}

// Vérifier si un ID de commande est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $commande_id = $_GET['id'];

    // Mise à jour du statut dans la BDD
    $req = $pdo->prepare("UPDATE commandes SET statut = 'Payée' WHERE id = ?");
    $success = $req->execute([$commande_id]);

    if ($success) {
        header("Location: caissier_dashboard.php?success=1");
    } else {
        header("Location: caissier_dashboard.php?error=1");
    }
    exit();
} else {
    header("Location: caissier_dashboard.php?error=invalid_id");
    exit();
}
?>
