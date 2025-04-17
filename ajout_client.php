<?php
require 'db.php';
session_start();

// Vérifier que l'utilisateur est un caissier
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'caissier') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!empty($nom) && !empty($email) && !empty($password)) {
        $req = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'client')");
        $req->execute([$nom, $email, $password]);
        $message = "✅ Client ajouté avec succès !";
    } else {
        $message = "⚠️ Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Client</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>➕ Ajouter un Client</h1>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>

        <label>Email :</label>
        <input type="email" name="email" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit" class="btn">Ajouter</button>
    </form>

    <a href="caissier_dashboard.php" class="btn">⬅ Retour</a>
</body>
</html>
