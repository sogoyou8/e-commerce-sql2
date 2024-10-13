<?php
require_once 'vendor/autoload.php'; // Inclure Composer

// Créer un objet Faker
$faker = Faker\Factory::create();

// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
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

    <h2>Utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Générer des utilisateurs fictifs
        for ($i = 0; $i < 10; $i++) {
            $lastName = escape($conn, $faker->lastName);
            $firstName = escape($conn, $faker->firstName);
            $email = escape($conn, $faker->email);
            $passwd = password_hash('password', PASSWORD_BCRYPT); // Générer un mot de passe crypté

            $sql = "INSERT INTO users (lastName, firstName, email, passwd) VALUES ('$lastName', '$firstName', '$email', '$passwd')";
            if ($conn->query($sql) === TRUE) {
                $userId = $conn->insert_id;
                echo "<tr><td>$userId</td><td>$lastName</td><td>$firstName</td><td>$email</td></tr>";

                // Ajouter des adresses pour chaque utilisateur
                $street = escape($conn, $faker->streetAddress);
                $city = escape($conn, $faker->city);
                $country = escape($conn, $faker->country);
                $postalCode = escape($conn, $faker->postcode);

                $sql = "INSERT INTO adresses (userId, street, city, country, postalCode) VALUES ('$userId', '$street', '$city', '$country', '$postalCode')";
                if (!$conn->query($sql)) {
                    echo "<tr><td colspan='4' class='error'>Erreur lors de l'ajout de l'adresse: " . $conn->error . "</td></tr>";
                }

                // Ajouter des informations de paiement pour chaque utilisateur
                $cardType = escape($conn, $faker->creditCardType);
                $cardNumber = escape($conn, $faker->creditCardNumber);
                $expirationDate = escape($conn, $faker->creditCardExpirationDateString);
                $cvv = escape($conn, $faker->randomNumber(3, true));

                $sql = "INSERT INTO payment (userId, cardType, cardNumber, expirationDate, cvv) VALUES ('$userId', '$cardType', '$cardNumber', '$expirationDate', '$cvv')";
                if (!$conn->query($sql)) {
                    echo "<tr><td colspan='4' class='error'>Erreur lors de l'ajout du paiement: " . $conn->error . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='error'>Erreur: " . $conn->error . "</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <h2>Produits</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Vendeur</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Générer des produits fictifs
        for ($i = 0; $i < 10; $i++) {
            $name = escape($conn, $faker->word);
            $price = $faker->randomFloat(2, 5, 100); // Prix entre 5 et 100
            $vendor = escape($conn, $faker->company);

            $sql = "INSERT INTO products (name, price, vendor) VALUES ('$name', '$price', '$vendor')";
            if ($conn->query($sql) === TRUE) {
                $productId = $conn->insert_id;
                echo "<tr><td>$productId</td><td>$name</td><td>$price</td><td>$vendor</td></tr>";

                // Ajouter des photos pour chaque produit
                $sql = "INSERT INTO photos (productId, image) VALUES ('$productId', NULL)";
                if (!$conn->query($sql)) {
                    echo "<tr><td colspan='4' class='error'>Erreur lors de l'ajout de la photo: " . $conn->error . "</td></tr>";
                }

                // Ajouter des avis pour chaque produit
                $stars = $faker->numberBetween(1, 5);
                $comment = escape($conn, $faker->sentence);
                $userId = $faker->numberBetween(1, 10);

                $sql = "INSERT INTO rates (userId, productId, stars, comment) VALUES ('$userId', '$productId', '$stars', '$comment')";
                if (!$conn->query($sql)) {
                    echo "<tr><td colspan='4' class='error'>Erreur lors de l'ajout de l'avis: " . $conn->error . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='error'>Erreur: " . $conn->error . "</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <h2>Factures</h2>
<table>
    <thead>
        <tr>
            <th>ID Utilisateur</th>
            <th>ID Produit</th>
            <th>Date de Facture</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Générer des factures fictives
    for ($i = 0; $i < 10; $i++) {
        $userId = $faker->numberBetween(1, 10);
        $productId = $faker->numberBetween(1, 10);
        $invoiceDate = $faker->dateTimeThisYear()->format('Y-m-d H:i:s');
        $unitPrice = $faker->randomFloat(2, 10, 100);
        $quantity = $faker->numberBetween(1, 5);
        $total = $unitPrice * $quantity;

        // Insertion de la facture
        $sql = "INSERT INTO invoices (userId, productId, invoiceDate, unitPrice, quantity, total) 
                VALUES ('$userId', '$productId', '$invoiceDate', '$unitPrice', '$quantity', '$total')";

        if ($conn->query($sql) === TRUE) {
            // Récupérer l'ID de la facture
            $invoiceId = $conn->insert_id;

            // Afficher les données dans le tableau HTML
            echo "<tr>";
            echo "<td>$userId</td>";
            echo "<td>$productId</td>";
            echo "<td>$invoiceDate</td>";
            echo "<td>$quantity</td>";
            echo "<td>$total</td>";
            echo "</tr>";

            // Ajouter des commandes pour chaque facture
            $departureDate = $faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $arrivalDate = $faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $deliveryCompany = escape($conn, $faker->company);
            $adressId = $faker->numberBetween(1, 10);

            // Assure-toi que `$invoiceId` est bien défini avant cette requête
            $sql = "INSERT INTO orders (invoiceId, productId, userId, adressId, departureDate, arrivalDate, deliveryCompany) 
                    VALUES ('$invoiceId', '$productId', '$userId', '$adressId', '$departureDate', '$arrivalDate', '$deliveryCompany')";

            if ($conn->query($sql) !== TRUE) {
                echo "<tr><td colspan='5' class='error'>Erreur lors de l'ajout de la commande: " . $conn->error . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='error'>Erreur lors de l'insertion de la facture: " . $conn->error . "</td></tr>";
        }
    }
    ?>
    </tbody>
</table>
</body>
</html>

<?php
$conn->close();
?>
