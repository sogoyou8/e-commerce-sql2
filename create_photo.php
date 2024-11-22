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

// Vérifier l'existence des clés dans $_POST et $_FILES
if (!isset($_POST['productId']) || !isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
    echo "Erreur: Les données du formulaire sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$productId = (int) $conn->real_escape_string($_POST['productId']);
$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));

// Vérifier si le produit existe
$sql = "SELECT * FROM products WHERE productId='$productId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Erreur: Le produit avec cet ID n'existe pas.";
    $conn->close();
    exit();
}

// Trouver le plus petit identifiant disponible pour la photo
$sql = "SELECT MIN(t1.photoId + 1) AS nextId FROM photos t1 LEFT JOIN photos t2 ON t1.photoId + 1 = t2.photoId WHERE t2.photoId IS NULL";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nextPhotoId = $row['nextId'];

// Si aucun identifiant n'est trouvé, utiliser l'auto-incrémentation
if (is_null($nextPhotoId)) {
    $sql = "INSERT INTO photos (productId, image) VALUES ('$productId', '$image')";
} else {
    $sql = "INSERT INTO photos (photoId, productId, image) VALUES ('$nextPhotoId', '$productId', '$image')";
}

if ($conn->query($sql) === TRUE) {
    echo "Nouvelle photo ajoutée avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>