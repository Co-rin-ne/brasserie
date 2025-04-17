<?php
require 'db.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur
$req = $pdo->prepare("SELECT nom, points_fidelite FROM utilisateurs WHERE id = ?");
$req->execute([$_SESSION['utilisateur_id']]);
$user = $req->fetch(PDO::FETCH_ASSOC);

// Récupérer les commandes de l'utilisateur
$req = $pdo->prepare("
    SELECT c.id, c.total, c.statut, c.date_commande 
    FROM commandes c 
    WHERE c.client_id = ? 
    ORDER BY c.date_commande DESC
");
$req->execute([$_SESSION['utilisateur_id']]);
$commandes = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1, h2 {
            text-align: center;
            color: #c1911f;
        }

        .points-container {
            text-align: center;
            font-size: 20px;
            margin: 20px 0;
            padding: 10px;
            background: #f8f1d4;
            border-radius: 10px;
            font-weight: bold;
        }

        .commande-container {
            width: 100%;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background: #c1911f;
            color: white;
        }

        .status {
            padding: 5px;
            border-radius: 5px;
        }

        .status-en-attente {
            background: orange;
            color: white;
        }

        .status-validee {
            background: green;
            color: white;
        }

        .status-refusee {
            background: red;
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            text-align: center;
            color: white;
            background: #c1911f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .btn:hover {
            background: #a37919;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Bienvenue, <?php echo htmlspecialchars($user['nom']); ?> 👋</h1>

        <div class="points-container">
            🔥 Vous avez <strong><?php echo $user['points_fidelite']; ?></strong> points de fidélité.
        </div>

        <h2>📦 Mes Commandes</h2>
        
        <div class="commande-container">
            <table>
                <tr>
                    <th>ID Commande</th>
                    <th>Date</th>
                    <th>Montant Total</th>
                    <th>Statut</th>
                </tr>
                <?php foreach ($commandes as $commande) : ?>
                    <tr>
                        <td>#<?php echo $commande['id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($commande['date_commande'])); ?></td>
                        <td><?php echo number_format($commande['total'], 2); ?> €</td>
                        <td>
                            <span class="status 
                                <?php echo ($commande['statut'] == 'En attente') ? 'status-en-attente' : 
                                          (($commande['statut'] == 'Validée') ? 'status-validee' : 'status-refusee'); ?>">
                                <?php echo $commande['statut']; ?>
                            </span>
                </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div style="text-align: center;">
            <a href="nouvelle_commande.php" class="btn">➕ Nouvelle Commande</a>
        </div>
    </div>

</body>
</html>
