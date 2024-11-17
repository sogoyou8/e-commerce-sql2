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

// Échapper les chaînes
$userId = $conn->real_escape_string($_POST['userId']);
$productId = $conn->real_escape_string($_POST['productId']);
$quantity = $conn->real_escape_string($_POST['quantity']);

// Insérer la commande dans la base de données
$sql = "INSERT INTO orders (userId, productId, quantity) VALUES ('$userId', '$productId', '$quantity')";

if ($conn->query($sql) === TRUE) {
    echo "Nouvelle commande ajoutée avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>