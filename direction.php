<?php
// Connexion à la base de données
$host = 'mysql-brasserie-terroir.alwaysdata.net';
$user = 'brasserie-terroir_1';
$password = '399552';
$dbname = 'wanbo204';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

// Récupération des données financières
$sql_finance = "
    SELECT 
        MONTH(date) AS mois, 
        SUM(CASE WHEN type = 'depense' THEN montant ELSE 0 END) AS total_depenses,
        SUM(CASE WHEN type = 'recette' THEN montant ELSE 0 END) AS total_recettes 
    FROM finances 
    GROUP BY mois
";
$result_finance = $conn->query($sql_finance);

// Récupération des ventes par produit
$sql_ventes = "
    SELECT 
        produit, 
        SUM(quantite) AS total_vendu 
    FROM ventes 
    GROUP BY produit
";
$result_ventes = $conn->query($sql_ventes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Direction</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        form { margin-top: 30px; }
        label { margin-right: 10px; }
        input, select { margin-right: 20px; }
    </style>
</head>
<body>

<h1>Tableau de Bord - Direction</h1>

<h2>Bilan Financier</h2>
<table>
    <tr>
        <th>Mois</th>
        <th>Total Dépenses</th>
        <th>Total Recettes</th>
    </tr>
    <?php while ($row = $result_finance->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['mois']; ?></td>
            <td><?php echo $row['total_depenses']; ?> €</td>
            <td><?php echo $row['total_recettes']; ?> €</td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Ajouter une Dépense / Recette</h2>
<form method="post" action="ajouter_transaction.php">
    <label for="date">Date :</label>
    <input type="date" id="date" name="date" required>

    <label for="type">Type :</label>
    <select id="type" name="type">
        <option value="depense">Dépense</option>
        <option value="recette">Recette</option>
    </select>

    <label for="montant">Montant :</label>
    <input type="number" id="montant" name="montant" step="0.01" required>

    <button type="submit">Ajouter</button>
</form>

<h2>Bilan Commercial</h2>
<table>
    <tr>
        <th>Produit</th>
        <th>Total Vendu</th>
    </tr>
    <?php while ($row = $result_ventes->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['produit']; ?></td>
            <td><?php echo $row['total_vendu']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
<?php
$conn->close();
?>