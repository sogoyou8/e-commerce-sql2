<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier l'existence de la clé dans $_GET
if (!isset($_GET['id'])) {
    echo "<script>alert('Erreur: L'ID de la photo est manquant.'); window.location.href='index.php';</script>";
    $conn->close();
    exit();
}

// Échapper les chaînes
$photoId = $conn->real_escape_string($_GET['id']);

// Supprimer la photo de la base de données
$sql = "DELETE FROM photos WHERE photoId='$photoId'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Photo supprimée avec succès'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Erreur: " . $conn->error . "'); window.location.href='index.php';</script>";
}

$conn->close();
?>