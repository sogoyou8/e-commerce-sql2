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
    $rateId = $conn->real_escape_string($_POST['rateId']);
    $userId = $conn->real_escape_string($_POST['userId']);
    $productId = $conn->real_escape_string($_POST['productId']);
    $stars = (int) $conn->real_escape_string($_POST['stars']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Mettre à jour l'évaluation dans la base de données
    $sql = "UPDATE rates SET userId='$userId', productId='$productId', stars='$stars', comment='$comment' WHERE rateId='$rateId'";

    if ($conn->query($sql) === TRUE) {
        echo "Évaluation mise à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations de l'évaluation
    $rateId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT rateId, userId, productId, stars, comment FROM rates WHERE rateId='$rateId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Évaluation non trouvée";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier évaluation</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Modifier évaluation</h1>
    <form action="update_rate.php" method="post">
        <input type="hidden" name="rateId" value="<?php echo $row['rateId']; ?>">
        <label for="userId">ID Utilisateur:</label>
        <input type="number" id="userId" name="userId" value="<?php echo $row['userId']; ?>" required>
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" value="<?php echo $row['productId']; ?>" required>
        <label for="stars">Étoiles:</label>
        <input type="number" id="stars" name="stars" min="1" max="5" value="<?php echo $row['stars']; ?>" required>
        <label for="comment">Commentaire:</label>
        <textarea id="comment" name="comment" required><?php echo $row['comment']; ?></textarea>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>