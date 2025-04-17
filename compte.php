<?php
require 'db.php';

// Supposons que l'utilisateur soit connecté et ait un ID de session
$client_id = 1; // Remplace par `$_SESSION['client_id']` si la connexion est active

$req = $pdo->prepare("SELECT nom, points_fidelite FROM clients WHERE id = ?");
$req->execute([$client_id]);
$client = $req->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
</head>
<body>
    <h1>Bonjour, <?php echo htmlspecialchars($client['nom']); ?></h1>
    <p>Vous avez <strong><?php echo $client['points_fidelite']; ?> points</strong> de fidélité.</p>
</body>
</html>
