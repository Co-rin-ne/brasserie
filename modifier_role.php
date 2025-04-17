<?php
require 'db.php';
session_start();

// Vérification si l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: erreur.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['role'])) {
    $id = $_POST['id'];
    $role = $_POST['role'];

    // Mise à jour du rôle dans la base de données
    $req = $pdo->prepare("UPDATE utilisateurs SET role = :role WHERE id = :id");
    $req->execute(['role' => $role, 'id' => $id]);

    header("Location: admin.php");
    exit();
}
?>
