<?php
// Connexion à la base de données MySQL
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
$lastName = $conn->real_escape_string($_POST['lastName']);
$firstName = $conn->real_escape_string($_POST['firstName']);
$email = $conn->real_escape_string($_POST['email']);
$passwd = $conn->real_escape_string($_POST['passwd']);

// Vérifier si l'email existe déjà
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Erreur: Un utilisateur avec cet email existe déjà.";
} else {
    // Insérer l'utilisateur dans la base de données
    $sql = "INSERT INTO users (lastName, firstName, email, passwd) VALUES ('$lastName', '$firstName', '$email', '$passwd')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel utilisateur ajouté avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

// Rediriger vers la page principale
header("Location: index.php");
exit();
?>