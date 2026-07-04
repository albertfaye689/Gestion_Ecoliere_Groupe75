<?php
// Configuration pour le serveur local XAMPP
$host = 'localhost';
$dbname = 'gestion_scolaire';
$username = 'root';
$password = '';

try {
    // Connexion sécurisée avec PDO (Bloque les injections SQL)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>