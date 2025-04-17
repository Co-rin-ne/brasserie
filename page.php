<?php include 'db.php'; 


// Récupération des données financières
$sql_finance = "SELECT MONTH(date) AS mois, SUM(CASE WHEN type = 'depense' THEN montant ELSE 0 END) AS total_depenses,
                SUM(CASE WHEN type = 'recette' THEN montant ELSE 0 END) AS total_recettes FROM finances GROUP BY mois";
$result_finance = $conn->query($sql_finance);

// Récupération des ventes par produit
$sql_ventes = "SELECT produit, SUM(quantite) AS total_vendu FROM ventes GROUP BY produit";
$result_ventes = $conn->query($sql_ventes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ftp.cluster029.hosting.ovh.netDashboard Direction</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h1>Tableau de Bord - Direction</h1>
    
    <h2>Bilan Financier</h2>
    <table>
        <tr><th>Mois</th><th>Total Dépenses</th><th>Total Recettes</th></tr>
        <?php while ($row = $result_finance->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['mois'] ?></td>
                <td><?= $row['total_depenses'] ?> €</td>
                <td><?= $row['total_recettes'] ?> €</td>
            </tr>
        <?php } ?>
    </table>
    
    <h2>Ajouter une Dépense / Recette</h2>
    <form method="post" action="ajouter_transaction.php">
        <label>Date :</label>
        <input type="date" name="date" required>
        <label>Type :</label>
        <select name="type">
            <option value="depense">Dépense</option>
            <option value="recette">Recette</option>
        </select>
        <label>Montant :</label>
        <input type="number" name="montant" required>
        <button type="submit">Ajouter</button>
    </form>
    
    <h2>Bilan Commercial</h2>
    <table>
        <tr><th>Produit</th><th>Total Vendu</th></tr>
        <?php while ($row = $result_ventes->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['produit'] ?></td>
                <td><?= $row['total_vendu'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>