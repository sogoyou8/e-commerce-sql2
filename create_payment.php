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
if (!isset($_POST['userId']) || !isset($_POST['cardType']) || !isset($_POST['cardNumber']) || !isset($_POST['expirationDate']) || !isset($_POST['cvv'])) {
    echo "Erreur: Les données du formulaire sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$userId = $conn->real_escape_string($_POST['userId']);
$cardType = $conn->real_escape_string($_POST['cardType']);
$cardNumber = $conn->real_escape_string($_POST['cardNumber']);
$expirationDate = $conn->real_escape_string($_POST['expirationDate']);
$cvv = $conn->real_escape_string($_POST['cvv']);

// Vérifier si l'utilisateur existe
$sql = "SELECT * FROM users WHERE userId='$userId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Erreur: L'utilisateur avec cet ID n'existe pas.";
    $conn->close();
    exit();
}

// Insérer le paiement dans la base de données
$sql = "INSERT INTO payment (userId, cardType, cardNumber, expirationDate, cvv) VALUES ('$userId', '$cardType', '$cardNumber', '$expirationDate', '$cvv')";

if ($conn->query($sql) === TRUE) {
    echo "Nouveau paiement ajouté avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>