<?php
require 'db.php'; // Connexion à la base de données
session_start();

// Fichiers de logs
$log_file = __DIR__ . '/logs/visitors.log';
$ban_file = __DIR__ . '/logs/banned_ips.log';
$attempts_file = __DIR__ . '/logs/attempts.json';

// Vérifier si le dossier logs existe, sinon le créer
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0777, true);
}

// Vérifier si les fichiers existent, sinon les créer
if (!file_exists($ban_file)) {
    file_put_contents($ban_file, json_encode([])); // Initialise avec un tableau vide
}
if (!file_exists($attempts_file)) {
    file_put_contents($attempts_file, json_encode([])); // Initialise avec un tableau vide
}

// Infos du visiteur
$ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d H:i:s");
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$page = $_SERVER['REQUEST_URI'];

// Ajouter une entrée dans le fichier de log
$log_entry = "[$date] IP: $ip - Page: $page - Agent: $user_agent\n";
file_put_contents($log_file, $log_entry, FILE_APPEND);

// Configuration de sécurité
$max_attempts = 4;
$ban_duration = 48 * 60 * 60; // 48 heures en secondes

// Charger les IP bannies
$banned_ips = json_decode(file_get_contents($ban_file), true);

// Vérifier si l'IP est bannie
if (isset($banned_ips[$ip]) && time() < $banned_ips[$ip]) {
    die("⛔ Vous êtes banni pour trop d'échecs de connexion. Réessayez plus tard.");
}

// Gestion des tentatives
$attempts = json_decode(file_get_contents($attempts_file), true);
$attempts[$ip] = isset($attempts[$ip]) ? $attempts[$ip] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérification de l'utilisateur dans la base de données
    $req = $pdo->prepare("SELECT id, nom, mot_de_passe, role FROM utilisateurs WHERE email = ?");
    $req->execute([$email]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Connexion réussie : on supprime les échecs
        unset($attempts[$ip]);
        file_put_contents($attempts_file, json_encode($attempts));

        $_SESSION['utilisateur_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];

        header("Location: " . ($user['role'] === 'admin' ? "admin_dashboard.php" : "user_dashboard.php"));
        exit();
    } else {
        // Enregistrement de l'échec
        $attempts[$ip]++;
        file_put_contents($attempts_file, json_encode($attempts));

        // Vérification du bannissement
        if ($attempts[$ip] >= $max_attempts) {
            $banned_ips[$ip] = time() + $ban_duration;
            file_put_contents($ban_file, json_encode($banned_ips));
            die("⛔ Trop d'échecs ! Vous êtes banni pendant 48 heures.");
        }

        // Écrire dans le log
        $error_log = "[$date] IP: $ip - Échec de connexion ($attempts[$ip]/$max_attempts)\n";
        file_put_contents($log_file, $error_log, FILE_APPEND);
        
        $erreur = "❌ Identifiants incorrects. Tentative " . $attempts[$ip] . " sur $max_attempts.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #dfaf2c;
            margin: 0;
        }

        .login-container {
            background-color: #f8f1d4;
            font-family: "Times New Roman", Times, serif;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        input {
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
        }

        button:hover {
            background-color: #a37919;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($erreur)) echo "<p class='error'>$erreur</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p><a href="index.php">Retour à l'accueil</a></p>
    </div>
</body>
</html>
