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

// Échapper les chaînes
$userId = $conn->real_escape_string($_GET['id']);

// Supprimer les commandes associées aux factures de l'utilisateur
$sql = "DELETE orders FROM orders 
        INNER JOIN invoices ON orders.invoiceId = invoices.invoiceId 
        WHERE invoices.userId='$userId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les commandes associées aux adresses de l'utilisateur
$sql = "DELETE orders FROM orders 
        INNER JOIN adresses ON orders.adressId = adresses.adressId 
        WHERE adresses.userId='$userId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les paiements associés à l'utilisateur
$sql = "DELETE FROM payment WHERE userId='$userId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les évaluations associées à l'utilisateur
$sql = "DELETE FROM rates WHERE userId='$userId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les factures associées à l'utilisateur
$sql = "DELETE FROM invoices WHERE userId='$userId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les adresses associées à l'utilisateur
$sql = "DELETE FROM adresses WHERE userId='$userId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer l'utilisateur de la base de données
$sql = "DELETE FROM users WHERE userId='$userId'";
if ($conn->query($sql) === TRUE) {
    echo "Utilisateur supprimé avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Échapper les chaînes
$adressId = $conn->real_escape_string($_GET['id']);

// Supprimer l'adresse de la base de données
$sql = "DELETE FROM adresses WHERE adressId='$adressId'";

if ($conn->query($sql) === TRUE) {
    echo "Adresse supprimée avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>