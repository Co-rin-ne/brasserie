<?php
require 'db.php'; // Connexion à la base de données

// Associer les ID des bières aux images correspondantes
$image_bieres = [
    1 => 'images/IPA.jpeg',
    2 => 'images/stout.jpeg',
    3 => 'images/lager.jpeg',
    4 => 'images/gin.jpg',
    5 => 'images/whisky.jpeg'
];

// Récupérer les bières uniquement
$req = $pdo->prepare("SELECT * FROM produits WHERE categorie = 'Bière'");
$req->execute();
$bieres = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Boissons</title>
    <?php include 'menu.php'; ?>

    <link rel="stylesheet" href="biere.css">
</head>
<body>

    <h1>Boissons</h1>

    <div class="biere-container">
        <?php foreach ($bieres as $biere) : ?>
            <div class="biere">
                <img src="<?php echo isset($image_bieres[$biere['id']]) ? $image_bieres[$biere['id']] : 'images/default.jpg'; ?>" 
                     alt="<?php echo htmlspecialchars($biere['nom']); ?>" 
                     class="biere-img">
                
                <h3><?php echo htmlspecialchars($biere['nom']); ?></h3>
                <p><?php echo htmlspecialchars($biere['description']); ?></p>
                <p><strong>Prix :</strong> <?php echo number_format($biere['prix'], 2); ?> €</p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
