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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Échapper les chaînes
    $userId = $conn->real_escape_string($_POST['userId']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $email = $conn->real_escape_string($_POST['email']);

    // Mettre à jour l'utilisateur dans la base de données
    $sql = "UPDATE users SET lastName='$lastName', firstName='$firstName', email='$email' WHERE userId='$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur mis à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Rediriger vers la page principale
    header("Location: index.php");
    exit();
} else {
    // Récupérer les informations de l'utilisateur
    $userId = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT userId, lastName, firstName, email FROM users WHERE userId='$userId'";
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
        <label for="nom">Nom:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $row['lastName']; ?>" required>
        <label for="prenom">Prénom:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $row['firstName']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>