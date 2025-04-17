<?php
require 'db.php';
session_start();

// Vérification de l'accès admin
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: erreur.php");
    exit();
}

// Vérifie que l'ID utilisateur est envoyé en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Empêche de supprimer son propre compte
    if ($id === $_SESSION['utilisateur_id']) {
        header("Location: admin.php?error=autodestruction");
        exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header("Location: admin.php?success=suppression");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    header("Location: admin.php?error=noid");
    exit();
}
