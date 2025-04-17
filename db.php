<?php
$host = "mysql-brasserie-terroir.alwaysdata.net";
$dbname = "brasserie-terroir_1";
$username = "399552";  // Modifier selon votre config
$password = "wanbo204";      // Modifier selon votre config

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
