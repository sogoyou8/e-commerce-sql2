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
    $userId = $conn->real_escape_string($_POST['userId']);
    $cardType = $conn->real_escape_string($_POST['cardType']);
    $cardNumber = $conn->real_escape_string($_POST['cardNumber']);
    $expirationDate = $conn->real_escape_string($_POST['expirationDate']);
    $cvv = $conn->real_escape_string($_POST['cvv']);

    // Mettre à jour le paiement dans la base de données
    $sql = "UPDATE payment SET cardType='$cardType', cardNumber='$cardNumber', expirationDate='$expirationDate', cvv='$cvv' WHERE userId='$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "Paiement mis à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations du paiement
    $userId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT userId, cardType, cardNumber, expirationDate, cvv FROM payment WHERE userId='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Paiement non trouvé";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier paiement</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Modifier paiement</h1>
    <form action="update_payment.php" method="post">
        <input type="hidden" name="userId" value="<?php echo $row['userId']; ?>">
        <label for="cardType">Type de carte:</label>
        <input type="text" id="cardType" name="cardType" value="<?php echo $row['cardType']; ?>" required>
        <label for="cardNumber">Numéro de carte:</label>
        <input type="text" id="cardNumber" name="cardNumber" value="<?php echo $row['cardNumber']; ?>" required>
        <label for="expirationDate">Date d'expiration:</label>
        <input type="text" id="expirationDate" name="expirationDate" value="<?php echo $row['expirationDate']; ?>" required>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" value="<?php echo $row['cvv']; ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>