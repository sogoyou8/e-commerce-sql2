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
    echo "Erreur: L'ID de l'utilisateur est manquant.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$userId = $conn->real_escape_string($_GET['id']);

// Supprimer le paiement de la base de données
$sql = "DELETE FROM payment WHERE userId='$userId'";

if ($conn->query($sql) === TRUE) {
    echo "Paiement supprimé avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>