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
    $orderId = $conn->real_escape_string($_POST['orderId']);
    $userId = $conn->real_escape_string($_POST['userId']);
    $productId = $conn->real_escape_string($_POST['productId']);
    $quantity = $conn->real_escape_string($_POST['quantity']);

    // Mettre à jour la commande dans la base de données
    $sql = "UPDATE orders SET userId='$userId', productId='$productId', quantity='$quantity' WHERE orderId='$orderId'";

    if ($conn->query($sql) === TRUE) {
        echo "Commande mise à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations de la commande
    $orderId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT orderId, userId, productId, quantity FROM orders WHERE orderId='$orderId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Commande non trouvée";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier commande</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Modifier commande</h1>
    <form action="update_order.php" method="post">
        <input type="hidden" name="orderId" value="<?php echo $row['orderId']; ?>">
        <label for="userId">ID Utilisateur:</label>
        <input type="number" id="userId" name="userId" value="<?php echo $row['userId']; ?>" required>
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" value="<?php echo $row['productId']; ?>" required>
        <label for="quantity">Quantité:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>