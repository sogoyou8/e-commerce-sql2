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
$productId = $conn->real_escape_string($_GET['id']);

// Supprimer les commandes associées aux factures du produit
$sql = "DELETE orders FROM orders 
        INNER JOIN invoices ON orders.invoiceId = invoices.invoiceId 
        WHERE invoices.productId='$productId'";

if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les factures associées au produit
$sql = "DELETE FROM invoices WHERE productId='$productId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les évaluations associées au produit
$sql = "DELETE FROM rates WHERE productId='$productId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer les photos associées au produit
$sql = "DELETE FROM photos WHERE productId='$productId'";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
    $conn->close();
    exit();
}

// Supprimer le produit de la base de données
$sql = "DELETE FROM products WHERE productId='$productId'";
if ($conn->query($sql) === TRUE) {
    echo "Produit supprimé avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>