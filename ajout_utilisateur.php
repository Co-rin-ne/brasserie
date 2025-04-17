<?php
require 'db.php'; // Connexion à la base de données
include '/logs/visitors.log' ;

if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'admin') {
    echo "⛔ Accès refusé.";
     exit();
 }


// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifier que les champs ne sont pas vides
    if (!empty($nom) && !empty($email) && !empty($password)) {
        try {
            // Requête SQL sans le champ "role"
            $req = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)");
            $req->execute([
                'nom' => $nom,
                'email' => $email,
                'mot_de_passe' => $password
            ]);

            $message = "✅ Utilisateur ajouté avec succès !";
        } catch (PDOException $e) {
            $message = "❌ Erreur : " . $e->getMessage();
        }
    } else {
        $message = "⚠️ Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Ajouter un utilisateur</h1>

    <!-- Affichage des messages -->
    <?php if (isset($message)) : ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>

        <label>Email :</label>
        <input type="email" name="email" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Ajouter</button>
    </form>

</body>
</html>
