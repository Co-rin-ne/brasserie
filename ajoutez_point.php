<?php
require 'db.php';
session_start();

// Vérification si l'utilisateur est admin
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'admin') {
    echo "⛔ Accès refusé.";
    exit();
}

// Récupérer la liste des utilisateurs
$req = $pdo->query("SELECT id, nom, email, points_fidelite FROM utilisateurs");
$utilisateurs = $req->fetchAll(PDO::FETCH_ASSOC);

// Ajout de points
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['utilisateur_id'], $_POST['points'])) {
    $utilisateur_id = $_POST['utilisateur_id'];
    $points = (int) $_POST['points'];

    $update = $pdo->prepare("UPDATE utilisateurs SET points_fidelite = points_fidelite + ? WHERE id = ?");
    $update->execute([$points, $utilisateur_id]);

    $message = "✅ Points ajoutés avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout Points de Fidélité</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1d4;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #c1911f;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #c1911f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #a37919;
        }

        .message {
            color: green;
            font-weight: bold;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #c1911f;
            font-weight: bold;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>🎁 Ajout de Points de Fidélité</h1>

<?php if (isset($message)) : ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<div class="container">
    <div class="card">
        <form method="POST">
            <label>👤 Sélectionner un utilisateur :</label>
            <select name="utilisateur_id" required>
                <option value="">-- Choisissez un utilisateur --</option>
                <?php foreach ($utilisateurs as $user) : ?>
                    <option value="<?php echo $user['id']; ?>">
                        <?php echo htmlspecialchars($user['nom']) . " (" . $user['email'] . ") - " . $user['points_fidelite'] . " points"; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>✨ Nombre de points à ajouter :</label>
            <input type="number" name="points" min="1" required>

            <button type="submit">➕ Ajouter les Points</button>
        </form>
    </div>
</div>

<a class="back-link" href="admin_dashboard.php">⬅ Retour au Tableau de Bord</a>

</body>
</html>
