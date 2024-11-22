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
if (!isset($_POST['lastName']) || !isset($_POST['firstName']) || !isset($_POST['email']) || !isset($_POST['passwd']) || !isset($_POST['street']) || !isset($_POST['city']) || !isset($_POST['country']) || !isset($_POST['postalCode'])) {
    echo "Erreur: Les données du formulaire sont manquantes.";
    $conn->close();
    exit();
}

// Échapper les chaînes
$lastName = $conn->real_escape_string($_POST['lastName']);
$firstName = $conn->real_escape_string($_POST['firstName']);
$email = $conn->real_escape_string($_POST['email']);
$passwd = $conn->real_escape_string($_POST['passwd']);
$street = $conn->real_escape_string($_POST['street']);
$city = $conn->real_escape_string($_POST['city']);
$country = $conn->real_escape_string($_POST['country']);
$postalCode = $conn->real_escape_string($_POST['postalCode']);

// Vérifier si l'email existe déjà
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Erreur: Un utilisateur avec cet email existe déjà.";
    $conn->close();
    exit();
}

// Trouver le plus petit identifiant disponible pour l'utilisateur
$sql = "SELECT MIN(t1.userId + 1) AS nextId FROM users t1 LEFT JOIN users t2 ON t1.userId + 1 = t2.userId WHERE t2.userId IS NULL";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nextUserId = $row['nextId'];

// Si aucun identifiant n'est trouvé, utiliser l'auto-incrémentation
if (is_null($nextUserId)) {
    $sql = "INSERT INTO users (lastName, firstName, email, passwd) VALUES ('$lastName', '$firstName', '$email', '$passwd')";
} else {
    $sql = "INSERT INTO users (userId, lastName, firstName, email, passwd) VALUES ('$nextUserId', '$lastName', '$firstName', '$email', '$passwd')";
}

if ($conn->query($sql) === TRUE) {
    // Récupérer l'ID de l'utilisateur nouvellement créé
    $userId = is_null($nextUserId) ? $conn->insert_id : $nextUserId;

    // Trouver le plus petit identifiant disponible pour l'adresse
    $sql = "SELECT MIN(t1.adressId + 1) AS nextId FROM adresses t1 LEFT JOIN adresses t2 ON t1.adressId + 1 = t2.adressId WHERE t2.adressId IS NULL";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $nextAdressId = $row['nextId'];

    // Insérer l'adresse dans la base de données
    if (is_null($nextAdressId)) {
        $sql = "INSERT INTO adresses (userId, street, city, country, postalCode) VALUES ('$userId', '$street', '$city', '$country', '$postalCode')";
    } else {
        $sql = "INSERT INTO adresses (adressId, userId, street, city, country, postalCode) VALUES ('$nextAdressId', '$userId', '$street', '$city', '$country', '$postalCode')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel utilisateur et adresse ajoutés avec succès";
    } else {
        echo "Erreur lors de l'ajout de l'adresse: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Erreur lors de l'ajout de l'utilisateur: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>