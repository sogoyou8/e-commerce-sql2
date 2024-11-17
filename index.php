<?php
// Connexion à la base de données
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

// Fonction pour échapper les chaînes
function escape($conn, $string) {
    return $conn->real_escape_string($string);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script de génération de données</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Ecommerce-db</h1>

    <h2>Ajouter un utilisateur</h2>
    <form action="create_user.php" method="post">
        <label for="lastName">Nom:</label>
        <input type="text" id="lastName" name="lastName" required>
        <label for="firstName">Prénom:</label>
        <input type="text" id="firstName" name="firstName" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="passwd">Mot de passe:</label>
        <input type="password" id="passwd" name="passwd" required>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Lire les utilisateurs de la base de données
        $sql = "SELECT userId, lastName, firstName, email FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les utilisateurs
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["userId"]. "</td>
                        <td>" . $row["lastName"]. "</td>
                        <td>" . $row["firstName"]. "</td>
                        <td>" . $row["email"]. "</td>
                        <td>
                            <a href='update_user.php?id=" . $row["userId"] . "'>Modifier</a>
                            <a href='delete_user.php?id=" . $row["userId"] . "'>Supprimer</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun utilisateur trouvé</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</body>
</html>