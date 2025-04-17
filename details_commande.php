<?php
require 'db.php';
session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit();
}

$commande_id = $_GET['id'];

$req = $pdo->prepare("
    SELECT c.id, c.total, c.statut, c.date_commande, p.nom, p.prix
    FROM commandes c
    JOIN commande_produits cp ON c.id = cp.commande_id
    JOIN produits p ON cp.produit_id = p.id
    WHERE c.id = ?
");
$req->execute([$commande_id]);
$details = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Commande</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>📝 Détails de la commande #<?php echo htmlspecialchars($commande_id); ?></h1>

    <?php if (!empty($details)) : ?>
        <p><strong>Date :</strong> <?php echo $details[0]['date_commande']; ?></p>
        <p><strong>Statut :</strong> <?php echo ucfirst($details[0]['statut']); ?></p>
        <p><strong>Total :</strong> <?php echo number_format($details[0]['total'], 2); ?> €</p>

        <h2>Produits commandés :</h2>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prix (€)</th>
            </tr>
            <?php foreach ($details as $produit) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                    <td><?php echo number_format($produit['prix'], 2); ?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>❌ Commande introuvable.</p>
    <?php endif; ?>

    <a href="user_dashboard..php" class="btn">⬅️ Retour</a>
</div>

</body>
</html>
