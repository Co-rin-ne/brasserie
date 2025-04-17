<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Brasserie Terroir&Saveur</title>
            <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="menu.css">
                <style>
                     .logo{
                            position: absolute;
                            top: 10px;
                            left: 10px;
                            width: 200px;
                            height: auto;
                        }
                    .texte-info{
                            background-color: beige;
                            font-family: "Times New Roman", Times, serif;
                            padding: 20px;
                            border-radius: 10px;
                            width: 50%;
                            margin: 20px auto;
                            text-align: center;
                            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    h2 {
                            margin-bottom: 10px;
                            justify-content: center;
                    }
                    .texte-pres{
                            font-family: "Times New Roman", Times, serif;
                            display : flex;  
                            flex-direction: column;
                            justify-content: space-around; 
                            align-items: center; 
                            text-align: center;
                    }   
                    .propos,
                    .propos-1{
                            background-color: #f8f1d4; /* Couleur plus claire */
                            font-family: "Times New Roman", Times, serif;
                            padding: 30px;
                            border-radius: 30px;
                            width: 400px;
                            text-align: center;
                            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                            margin: 20px auto  
                    }

                    .cuve {
                        width: 400px;
                        height: auto;
                        border-radius: 15px;
                        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                    }
                
                    .contact{
                            background-color: #f8f1d4; /* Couleur plus claire */
                            font-family: "Times New Roman", Times, serif;
                            padding: 30px;
                            border-radius: 10px;
                            width: 300px;
                            margin: 20px auto;
                            text-align: center;
                            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                    }
                </style>    
</head>
<body>

<header>
    <h1>Bienvenue à la Brasserie Terroir & Saveur</h1>
        <p>Découvrez nos spécialités</p>
    <p> Une brasserie artisanale où passion et savoir-faire se rencontrent pour créer des bières authentiques.</p>
    <br>
    <br>
    <!-- Inclusion du menu -->
    <?php include 'menu.php'; ?>
</header>
    <img src= "images/logo.png" class="logo">
        <div class="texte-pres">
            <br>
                
                    <div class = "propos">
                        <strong>🌿 Un engagement envers le terroir</strong>
                    <br>
                    Nous sélectionnons des ingrédients de qualité, issus de producteurs locaux, pour offrir des saveurs uniques et respectueuses de notre environnement.
                    <br>
                        <strong>🍺 Un brassage entre tradition et innovation</strong>
                    <br>
                    Grâce à nos cuves de brassage modernes, nous revisitons des recettes classiques tout en explorant de nouvelles créations audacieuses. Chaque bière raconte une histoire, mêlant héritage brassicole et créativité.
                    </div> 
                        <br>

                        <img src = "images/cuve.jpeg" class ="cuve">
                        <br>
                    <div class= "propos-1">
                        <strong> 👥 Une aventure humaine et conviviale </strong>
                    <br>
                    Derrière chaque brassin, il y a une équipe passionnée, soucieuse de partager son amour du bon produit. Nous vous invitons à découvrir nos bières et à vivre un moment chaleureux avec nous.
                    <br>
                        <strong>📍 Venez nous rencontrer !</strong>
                    <br>
                    Que ce soit pour une dégustation, une visite de la brasserie ou simplement un moment d’échange, nous serons ravis de vous accueillir.
                    <br>
                    </div>
        </div>
    <br>
        <div class="texte-info">
                <h2>Qui nous sommes?</h2>
            <p>Chez Brasserie Terroir & Saveur, nous brassons avec passion des bières authentiques, inspirées de notre terroir. Grâce à nos cuves de brassage et des ingrédients soigneusement sélectionnés, nous créons des saveurs uniques, mêlant tradition et modernité. Venez découvrir notre savoir-faire et partager un moment convivial autour de nos créations !</p>
        </div>
        <div class="contact"> 
            <h2>Contact</h2>
        <br>
            <br><input type="Email" id="loginEmail" placeholder="contact@example.com"> 
        <br>
            <p><input type = "Téléphone" id="num" placeholder="+33 6 12 34 56 78">
        <br>      
            <p><input type = "demande" id="dem" placeholder="Rédiger une demande" style="width: 300px; height: 50px; font-size: 16px;">
        <br>
            <a href="mailto:exemple@email.com">Contact par e-mail</e-mail></a>
        </div>
            <p id="contact"> </p>
<br> 
<footer>
    <p> © 2025 Brasserie Terroir & Saveur - Tous droits réservés. </p>
</footer>

</body>
</html>
