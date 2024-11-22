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
    $oldUserId = $conn->real_escape_string($_POST['oldUserId']);
    $oldProductId = $conn->real_escape_string($_POST['oldProductId']);
    $newUserId = $conn->real_escape_string($_POST['newUserId']);
    $newProductId = $conn->real_escape_string($_POST['newProductId']);

    // Mettre à jour l'article du panier
    $sql = "UPDATE cart SET userId='$newUserId', productId='$newProductId' WHERE userId='$oldUserId' AND productId='$oldProductId'";

    if ($conn->query($sql) === TRUE) {
        echo "Article du panier mis à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations de l'article du panier
    $userId = $conn->real_escape_string($_GET['userId']);
    $productId = $conn->real_escape_string($_GET['productId']);
    $sql = "SELECT userId, productId FROM cart WHERE userId='$userId' AND productId='$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Article du panier non trouvé";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier article du panier</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Modifier article du panier</h1>
    <form action="update_cart.php" method="post">
        <input type="hidden" name="oldUserId" value="<?php echo $row['userId']; ?>">
        <input type="hidden" name="oldProductId" value="<?php echo $row['productId']; ?>">
        <label for="newUserId">ID Utilisateur:</label>
        <input type="number" id="newUserId" name="newUserId" value="<?php echo $row['userId']; ?>" required>
        <label for="newProductId">ID Produit:</label>
        <input type="number" id="newProductId" name="newProductId" value="<?php echo $row['productId']; ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>