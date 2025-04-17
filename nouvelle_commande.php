<?php
require 'db.php';
session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['utilisateur_id'];

// Récupérer les produits
$req = $pdo->query("SELECT * FROM produits");
$produits = $req->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produits_selectionnes = $_POST['produits'] ?? [];
    
    if (!empty($produits_selectionnes)) {
        $total = 0;
        foreach ($produits_selectionnes as $produit_id) {
            $req = $pdo->prepare("SELECT prix FROM produits WHERE id = ?");
            $req->execute([$produit_id]);
            $produit = $req->fetch(PDO::FETCH_ASSOC);
            $total += $produit['prix'];
        }

        // Insérer la commande
        $req = $pdo->prepare("INSERT INTO commandes (client_id, total, statut) VALUES (?, ?, 'en attente')");
        $req->execute([$client_id, $total]);

        header("Location: user.php");
        exit();
    } else {
        $message = "⚠️ Sélectionnez au moins un produit.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Commande</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>🛒 Nouvelle Commande</h1>

    <?php if (isset($message)) echo "<p class='error'>$message</p>"; ?>

    <form method="POST">
        <?php foreach ($produits as $produit) : ?>
            <label>
                <input type="checkbox" name="produits[]" value="<?php echo $produit['id']; ?>">
                <?php echo htmlspecialchars($produit['nom']); ?> - <?php echo number_format($produit['prix'], 2); ?> €
            </label><br>
        <?php endforeach; ?>

        <button type="submit" class="btn">✅ Passer la commande</button>
    </form>

    <a href="user_dashboard.php" class="btn">⬅️ Retour</a>
</div>

</body>
</html>
