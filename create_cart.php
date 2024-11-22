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
if (!isset($_POST['userId']) || !isset($_POST['productId'])) {
    echo "Erreur: Les données du formulaire sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$userId = $conn->real_escape_string($_POST['userId']);
$productId = $conn->real_escape_string($_POST['productId']);

// Vérifier si l'utilisateur existe
$sql = "SELECT * FROM users WHERE userId='$userId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Erreur: L'utilisateur avec cet ID n'existe pas.";
    $conn->close();
    exit();
}

// Vérifier si le produit existe
$sql = "SELECT * FROM products WHERE productId='$productId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Erreur: Le produit avec cet ID n'existe pas.";
    $conn->close();
    exit();
}

// Ajouter l'article au panier
$sql = "INSERT INTO cart (userId, productId) VALUES ('$userId', '$productId')";

if ($conn->query($sql) === TRUE) {
    echo "Article ajouté au panier avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>