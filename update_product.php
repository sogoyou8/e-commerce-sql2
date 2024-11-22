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
    $productId = $conn->real_escape_string($_POST['productId']);
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $vendor = $conn->real_escape_string($_POST['vendor']);

    // Mettre à jour le produit dans la base de données
    $sql = "UPDATE products SET name='$name', price='$price', vendor='$vendor' WHERE productId='$productId'";

    if ($conn->query($sql) === TRUE) {
        echo "Produit mis à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations du produit
    $productId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT productId, name, price, vendor FROM products WHERE productId='$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produit non trouvé";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier produit</title>
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

    <h1>Modifier produit</h1>
    <form action="update_product.php" method="post">
        <input type="hidden" name="productId" value="<?php echo $row['productId']; ?>">
        <label for="name">Nom du produit:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
        <label for="price">Prix:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $row['price']; ?>" required>
        <label for="vendor">Vendeur:</label>
        <input type="text" id="vendor" name="vendor" value="<?php echo $row['vendor']; ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>