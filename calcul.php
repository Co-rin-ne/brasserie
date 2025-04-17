<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $volume_bière = $_POST["volume_bière"];
    $alcool = $_POST["alcool"];
    $moyenne_EBC = $_POST["moyenne_EBC"];
    $type_grain = $_POST["type_grain"];
    $poidsenKg = $_POST["poidsenKg"];

    $grains = [
        "Pils" => 4,     
        "Amber" => 60 
    ];

    //regarde si le grain existe dans le tableau
    if (array_key_exists($type_grain, $grains)) {
        $moyenne_ebc = $grains[$type_grain];


    $malt_total = ($volume_bière * $alcool)/ 20;
    $eau_brassage = $malt_total * 2.8;
    $eau_rinçage = ($volume_bière * 1.25) - ($eau_brassage * 0.7);
    $MCU = (4.23 * ($moyenne_EBC * $poidsenKg)) / $volume_bière ;
    $EBC = 2.9396 * pow($MCU, 0.6859); 
    $SRM = 0.508 * $EBC;
    $houblon_amer = $volume_bière * 3;
    $houblon_arom = $volume_bière * 1; 
    $levure = $volume_bière / 2;  

    echo "<h2> Résultats:</h2> ";
    echo "Quantité de malt: " . number_format($malt_total, 2). "kg <br>"; 
    echo "Volume eau de brassage: " . number_format($eau_brassage, 2) . "L <br>"; 
    echo "Volume eau de rinçage: " . number_format($eau_rinçage, 2) . "L <br>"; 
    echo "Quantité de houblon amérisant: " . number_format($houblon_amer, 1) . "g <br>" ;  
    echo "Quantité de houblon arométique: " . number_format($houblon_arom, 1) . "g <br>"; 
    echo "Quantité de levure: " . number_format($levure, 2) . "g <br>"; 

        // Affichage
        echo "<h2>Colorimétrie:</h2>";
        echo "Grain sélectionné : $type_grain<br>";
        echo "MCU: " . number_format($MCU, 2) . "<br>";
        echo "EBC: " . number_format($EBC, 2) . "<br>";
        echo "SRM: " . number_format($SRM, 2) . "<br>";
    } else {
        echo "Type de grain inconnu.";
    }   
}
?>
<p><a href ="index.php"> Retour à l'acceuil</a></p>
<link rel="stylesheet" href="style1.css">