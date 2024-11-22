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

// Vérifier l'existence des clés dans $_GET
if (!isset($_GET['userId']) || !isset($_GET['productId'])) {
    echo "Erreur: Les données de l'article du panier sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$userId = $conn->real_escape_string($_GET['userId']);
$productId = $conn->real_escape_string($_GET['productId']);

// Supprimer l'article du panier de la base de données
$sql = "DELETE FROM cart WHERE userId='$userId' AND productId='$productId'";

if ($conn->query($sql) === TRUE) {
    echo "Article du panier supprimé avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>