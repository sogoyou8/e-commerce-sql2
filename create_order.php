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

// Échapper les chaînes et convertir en nombres
$userId = (int) $conn->real_escape_string($_POST['userId']);
$productId = (int) $conn->real_escape_string($_POST['productId']);
$quantity = (int) $conn->real_escape_string($_POST['quantity']);

// Vérifier si l'utilisateur existe
$sql = "SELECT * FROM users WHERE userId='$userId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Erreur: L'utilisateur avec cet ID n'existe pas.";
    $conn->close();
    exit();
}

// Vérifier si le produit existe
$sql = "SELECT price FROM products WHERE productId='$productId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Erreur: Le produit avec cet ID n'existe pas.";
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
$price = (float) $row['price'];
$total = $quantity * $price;

// Insérer la commande dans la base de données
$sql = "INSERT INTO invoices (userId, productId, invoiceDate, quantity, total) VALUES ('$userId', '$productId', NOW(), '$quantity', '$total')";

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