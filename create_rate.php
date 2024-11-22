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
if (!isset($_POST['userId']) || !isset($_POST['productId']) || !isset($_POST['stars']) || !isset($_POST['comment'])) {
    echo "Erreur: Les données du formulaire sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$userId = $conn->real_escape_string($_POST['userId']);
$productId = $conn->real_escape_string($_POST['productId']);
$stars = (int) $conn->real_escape_string($_POST['stars']);
$comment = $conn->real_escape_string($_POST['comment']);

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

// Trouver le plus petit identifiant disponible pour l'évaluation
$sql = "SELECT MIN(t1.rateId + 1) AS nextId FROM rates t1 LEFT JOIN rates t2 ON t1.rateId + 1 = t2.rateId WHERE t2.rateId IS NULL";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nextRateId = $row['nextId'];

// Si aucun identifiant n'est trouvé, utiliser l'auto-incrémentation
if (is_null($nextRateId)) {
    $sql = "INSERT INTO rates (userId, productId, stars, comment) VALUES ('$userId', '$productId', '$stars', '$comment')";
} else {
    $sql = "INSERT INTO rates (rateId, userId, productId, stars, comment) VALUES ('$nextRateId', '$userId', '$productId', '$stars', '$comment')";
}

if ($conn->query($sql) === TRUE) {
    echo "Nouvelle évaluation ajoutée avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>