<?php
require 'db.php';
session_start();

// Vérification que l'utilisateur est bien caissier
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'caissier') {
    header("Location: erreur.php");
    exit();
}

// Récupération des commandes avec info clients
$req = $pdo->query("
    SELECT commandes.id, commandes.total, commandes.date_commande, commandes.statut, utilisateurs.nom AS client_nom, utilisateurs.id AS client_id
    FROM commandes
    JOIN utilisateurs ON commandes.client_id = utilisateurs.id
    ORDER BY commandes.date_commande DESC
");
$commandes = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Caissier</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f6f5f3;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #c1911f;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .logout a {
            text-decoration: none;
            background-color: #b43d3d;
            color: white;
            padding: 7px 12px;
            border-radius: 4px;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #c1911f;
            color: white;
        }

        input[type=number] {
            width: 60px;
            padding: 5px;
        }

        button {
            background-color: #c1911f;
            color: white;
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #a37919;
        }
    </style>
</head>
<body>

<div class="logout">
    <a href="logout.php">Se déconnecter</a>
</div>

<h1>Tableau de Bord du Caissier</h1>

<table>
    <tr>
        <th>ID Commande</th>
        <th>Nom du Client</th>
        <th>ID Client</th>
        <th>Date</th>
        <th>Total (€)</th>
        <th>Statut</th>
        <th>Points Fidélité</th>
        <th>Action</th>
    </tr>

    <?php foreach ($commandes as $commande): ?>
        <tr>
            <td><?= $commande['id'] ?></td>
            <td><?= htmlspecialchars($commande['client_nom']) ?></td>
            <td><?= $commande['client_id'] ?></td>
            <td><?= $commande['date_commande'] ?></td>
            <td><?= number_format($commande['total'], 2, ',', ' ') ?></td>
            <td><?= ucfirst($commande['statut']) ?></td>
            <td>
                <?php if ($commande['statut'] !== 'payée'): ?>
                    <form action="validez_commandes.php" method="POST">
                        <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                        <input type="hidden" name="client_id" value="<?= $commande['client_id'] ?>">
                        <input type="number" name="points" min="0" placeholder="Points" required>
                <?php else: ?>
                    ✔️ Déjà payée
                <?php endif; ?>
            </td>
            <td>
                <?php if ($commande['statut'] !== 'payée'): ?>
                        <button type="submit">Valider</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
