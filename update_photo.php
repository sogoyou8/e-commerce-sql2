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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Échapper les chaînes
    $photoId = $conn->real_escape_string($_POST['photoId']);
    $productId = $conn->real_escape_string($_POST['productId']);
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));

    // Mettre à jour la photo dans la base de données
    $sql = "UPDATE photos SET productId='$productId', image='$image' WHERE photoId='$photoId'";

    if ($conn->query($sql) === TRUE) {
        echo "Photo mise à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations de la photo
    $photoId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT photoId, productId, image FROM photos WHERE photoId='$photoId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Photo non trouvée";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier photo</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

    <div class="navbar">
        <a href="index.php">Accueil</a>
        <a href="add_user.php">Ajouter Utilisateur</a>
        <a href="add_product.php">Ajouter Produit</a>
        <a href="add_photo.php">Ajouter Photo</a>
        <a href="add_rate.php">Ajouter Évaluation</a>
        <a href="add_payment.php">Ajouter Paiement</a>
        <a href="add_to_cart.php">Ajouter au Panier</a>
        <a href="index.php">Retour à l'accueil</a>
    </div>

    <h1>Modifier photo</h1>
    <form action="update_photo.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="photoId" value="<?php echo $row['photoId']; ?>">
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" value="<?php echo $row['productId']; ?>" required>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>