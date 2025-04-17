<?php include 'db.php';

session_start();

// Ajouter un produit
if (isset($_POST['ajouter'])) {
    $stmt = $pdo->prepare("INSERT INTO produits_finis (nom, quantite) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['nom'], $_POST['quantite']]);
}

// Supprimer
if (isset($_GET['supprimer'])) {
    $stmt = $pdo->prepare("DELETE FROM produits_finis WHERE id = ?");
    $stmt->execute([$_GET['supprimer']]);
}

// Modifier
if (isset($_POST['modifier'])) {
    $stmt = $pdo->prepare("UPDATE produits_finis SET nom = ?, quantite = ? WHERE id = ?");
    $stmt->execute([$_POST['nom'], $_POST['quantite'], $_POST['id']]);
}

// Evite qu'un role se connecte à un autre 
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'brasseur') {
    header("Location: erreur.php");
    exit();
}

// Récupérer tous les produits
$produits = $pdo->query("SELECT * FROM produits_finis")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion du Stock - Brasserie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h1 class="text-center mb-4">Gestion des Produits Finis</h1>

        <form method="POST" class="card p-3 mb-4 shadow-sm">
            <input type="hidden" name="id" value="<?= $_GET['edit'] ?? '' ?>">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="quantite" class="form-control" placeholder="Quantité" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="<?= isset($_GET['edit']) ? 'modifier' : 'ajouter' ?>" class="btn btn-primary w-100">
                        <?= isset($_GET['edit']) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </div>
        </form>

        <table class="table table-bordered shadow-sm bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nom'] ?? '') ?></td>
                        <td><?= $produit['quantite'] ?></td>
                        <td>
                            <a href="?edit=<?= $produit['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                            <a href="?supprimer=<?= $produit['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <p><a href ="index.php"> Retour à l'acceuil</a></p>
</body>
</html>