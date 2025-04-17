<?php include 'db.php'; ?>
<?php include 'calcul.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style1.css">
     <title>Outils de brassage</title>
</head>
<body>
    <h1> Votre espace de brassage</h1>
<br>
    <div class = "Calcul">
        <form action = "calcul.php" method = "POST">
        <label for = "volume_bière" >Volume à brasser (en L):</label>
        <input type ="number" name ="volume_bière" required> 
    <br>
        <label for = "alcool"> Volume d'alcool recherché (en %):</label> 
        <input type = "number" name = "alcool" required> 
    <br>
        <label for = "moyenne_EBC"> Moyenne EBC des grains: </label> 
        <input type = "number" name="moyenne_EBC" required>
    <br> 
        <button type = "submit"> Brassé ! </button> 
    <br>
    <label>Type de grain :</label>
    <select name="type_grain" required>
        <option value="Pils">Pils</option>
        <option value="Amber">Amber</option>
    </select><br>
    <label> Poids du grain:</label> 
    <select name="poidsenKg" required>
        <option value="0.33">0.33</option>
        <option value="0.17">0.17</option>
    </select><br>
    <p><a href ="index.php"> Retour à l'acceuil</a></p>
    </div>
</body> 
</html> 


