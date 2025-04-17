<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Erreur - Brasserie Terroir</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: "Times New Roman", Times, serif;
            background: linear-gradient(to right, #dfaf2c, #c1911f);
            color: #fff;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 80px;
            margin: 0;
            color: #f8f1d4;
        }

        p {
            font-size: 20px;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            text-decoration: none;
            background: #c1911f;
            color: white;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #a37919;
        }
    </style>
</head>

<body>

    <div class="error-container">
        <h1>🚫 404</h1>
        <p>Oups ! La page que vous recherchez est introuvable ou vous n'avez pas les droits d'accès.</p>

        <?php if (!isset($_SESSION['utilisateur_id'])) : ?>
            <p><a href="connexion.php" class="btn">Se connecter</a></p>
        <?php else : ?>
            <p><a href="index.php" class="btn">Retour au tableau de bord</a></p>
        <?php endif; ?>

    </div>

</body>

</html>
