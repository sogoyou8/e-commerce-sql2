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

// Vérifier l'existence des clés dans $_POST
if (!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['vendor'])) {
    echo "Erreur: Les données du formulaire sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$name = $conn->real_escape_string($_POST['name']);
$price = $conn->real_escape_string($_POST['price']);
$vendor = $conn->real_escape_string($_POST['vendor']);

// Trouver le plus petit identifiant disponible pour le produit
$sql = "SELECT MIN(t1.productId + 1) AS nextId FROM products t1 LEFT JOIN products t2 ON t1.productId + 1 = t2.productId WHERE t2.productId IS NULL";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nextProductId = $row['nextId'];

// Si aucun identifiant n'est trouvé, utiliser l'auto-incrémentation
if (is_null($nextProductId)) {
    $sql = "INSERT INTO products (name, price, vendor) VALUES ('$name', '$price', '$vendor')";
} else {
    $sql = "INSERT INTO products (productId, name, price, vendor) VALUES ('$nextProductId', '$name', '$price', '$vendor')";
}

if ($conn->query($sql) === TRUE) {
    echo "Nouveau produit ajouté avec succès";
} else {
    echo "Erreur lors de l'ajout du produit: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>