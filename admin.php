<?php
require 'db.php';
session_start();

// Vérification si l'utilisateur est admin
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: erreur.php");
    exit();
}

// Récupération des utilisateurs
$req = $pdo->query("SELECT id, nom, email, role FROM utilisateurs");
$utilisateurs = $req->fetchAll(PDO::FETCH_ASSOC);

// Gestion de l'ajout d'un utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if (!empty($nom) && !empty($email) && !empty($_POST['password'])) {
        try {
            $req = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, :role)");
            $req->execute([
                'nom' => $nom,
                'email' => $email,
                'mot_de_passe' => $password,
                'role' => $role
            ]);
            header("Location: admin_utilisateurs.php?success=ajout");
            exit();
        } catch (PDOException $e) {
            $message = "❌ Erreur : " . $e->getMessage();
        }
    } else {
        $message = "⚠️ Veuillez remplir tous les champs.";
    }
}

// ✅ Gestion de la suppression d’un utilisateur + prévention auto-suppression
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer'])) {
    $id = $_POST['id'];

    if ($id == $_SESSION['utilisateur_id']) {
        $message = "❌ Vous ne pouvez pas supprimer votre propre compte.";
    } else {
        try {
            $req = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
            $req->execute(['id' => $id]);
            header("Location: supprimer_utilsateur.php?success=suppression");
            exit();
        } catch (PDOException $e) {
            $message = "❌ Erreur lors de la suppression.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #dfaf2c;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            color: #fff;
        }

        .table-admin {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table-admin th, .table-admin td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .table-admin th {
            background-color: #c1911f;
            color: white;
        }

        .form-ajout {
            margin: 20px auto;
            text-align: center;
        }

        input, select, button {
            padding: 7px;
            margin: 5px;
        }

        button {
            background-color: #c1911f;
            color: white;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
        }

        button:hover {
            background-color: #a37919;
        }

        .btn-danger {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: darkred;
        }

        .message {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ffeeba;
            border-radius: 5px;
            width: 60%;
            margin: 20px auto;
        }
    </style>
</head>

<body>

<h1>Gestion des Utilisateurs</h1>

<?php if (isset($message)) : ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<table class="table-admin">
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>
    <?php foreach ($utilisateurs as $user) : ?>
        <tr>
            <td><?php echo htmlspecialchars($user['nom']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <form action="modifier_role.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <select name="role">
                        <option value="client" <?php if ($user['role'] === 'client') echo 'selected'; ?>>Client</option>
                        <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="caissier" <?php if ($user['role'] === 'caissier') echo 'selected'; ?>>Caissier</option>
                        <option value="brasseur" <?php if ($user['role'] === 'brasseur') echo 'selected'; ?>>Brasseur</option>
                    </select>
                    <button type="submit">Modifier</button>
                </form>
            </td>
            <td>
                <form action="supprimer_utilisateur.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <button type="submit" name="supprimer" class="btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Formulaire d'ajout d'utilisateur -->
<h2>Ajouter un nouvel utilisateur</h2>
<form class="form-ajout" method="POST">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <select name="role">
        <option value="client">Client</option>
        <option value="admin">Admin</option>
        <option value="caissier">Caissier</option>
        <option value="brasseur">Brasseur</option>
    </select>
    <button type="submit" name="ajout">Ajouter</button>
</form>

<p><a href="admin_dashboard.php">Retour au tableau de bord</a></p>

</body>
</html>
