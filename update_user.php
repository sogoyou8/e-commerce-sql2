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
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $email = $conn->real_escape_string($_POST['email']);
    $adressId = $conn->real_escape_string($_POST['adressId']);
    $street = $conn->real_escape_string($_POST['street']);
    $city = $conn->real_escape_string($_POST['city']);
    $country = $conn->real_escape_string($_POST['country']);
    $postalCode = $conn->real_escape_string($_POST['postalCode']);

    // Mettre à jour l'utilisateur dans la base de données
    $sql = "UPDATE users SET lastName='$lastName', firstName='$firstName', email='$email' WHERE userId='$userId'";

    if ($conn->query($sql) === TRUE) {
        // Mettre à jour l'adresse dans la base de données
        $sql = "UPDATE adresses SET street='$street', city='$city', country='$country', postalCode='$postalCode' WHERE adressId='$adressId'";

        if ($conn->query($sql) === TRUE) {
            echo "Utilisateur et adresse mis à jour avec succès";
        } else {
            echo "Erreur lors de la mise à jour de l'adresse: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erreur lors de la mise à jour de l'utilisateur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations de l'utilisateur et de l'adresse
    $userId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT users.userId, users.lastName, users.firstName, users.email, adresses.adressId, adresses.street, adresses.city, adresses.country, adresses.postalCode 
            FROM users 
            LEFT JOIN adresses ON users.userId = adresses.userId 
            WHERE users.userId='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Utilisateur non trouvé";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Modifier utilisateur</h1>
    <form action="update_user.php" method="post">
        <input type="hidden" name="userId" value="<?php echo $row['userId']; ?>">
        <label for="lastName">Nom:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $row['lastName']; ?>" required>
        <label for="firstName">Prénom:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $row['firstName']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        <input type="hidden" name="adressId" value="<?php echo $row['adressId']; ?>">
        <label for="street">Rue:</label>
        <input type="text" id="street" name="street" value="<?php echo $row['street']; ?>" required>
        <label for="city">Ville:</label>
        <input type="text" id="city" name="city" value="<?php echo $row['city']; ?>" required>
        <label for="country">Pays:</label>
        <input type="text" id="country" name="country" value="<?php echo $row['country']; ?>" required>
        <label for="postalCode">Code Postal:</label>
        <input type="text" id="postalCode" name="postalCode" value="<?php echo $row['postalCode']; ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>