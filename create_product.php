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
$name = $conn->real_escape_string($_POST['name']);
$price = $conn->real_escape_string($_POST['price']);
$vendor = $conn->real_escape_string($_POST['vendor']);

// Insérer le produit dans la base de données
$sql = "INSERT INTO products (name, price, vendor) VALUES ('$name', '$price', '$vendor')";

if ($conn->query($sql) === TRUE) {
    echo "Nouveau produit ajouté avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>