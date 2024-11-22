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
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <h1>Ecommerce-db</h1>

    <div class="navbar">
        <a href="index.php">Accueil</a>
        <a href="add_user.php">Ajouter Utilisateur</a>
        <a href="add_product.php">Ajouter Produit</a>
        <a href="add_photo.php">Ajouter Photo</a>
        <a href="add_rate.php">Ajouter Évaluation</a>
        <a href="add_payment.php">Ajouter Paiement</a>
        <a href="add_to_cart.php">Ajouter au Panier</a>
    </div>

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
        <label for="street">Rue:</label>
        <input type="text" id="street" name="street" required>
        <label for="city">Ville:</label>
        <input type="text" id="city" name="city" required>
        <label for="country">Pays:</label>
        <input type="text" id="country" name="country" required>
        <label for="postalCode">Code Postal:</label>
        <input type="text" id="postalCode" name="postalCode" required>
        <button type="submit">Ajouter</button>
    </form>

    <h2>Liste des utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>ID Adresse</th>
                <th>Rue</th>
                <th>Ville</th>
                <th>Pays</th>
                <th>Code Postal</th>
                <th>Type de carte</th>
                <th>Numéro de carte</th>
                <th>Date d'expiration</th>
                <th>CVV</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Lire les utilisateurs et les paiements de la base de données
        $sql = "SELECT users.userId, users.lastName, users.firstName, users.email, adresses.adressId, adresses.street, adresses.city, adresses.country, adresses.postalCode, payment.cardType, payment.cardNumber, payment.expirationDate, payment.cvv 
                FROM users 
                LEFT JOIN adresses ON users.userId = adresses.userId
                LEFT JOIN payment ON users.userId = payment.userId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les utilisateurs et les paiements
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["userId"]. "</td>
                        <td>" . $row["lastName"]. "</td>
                        <td>" . $row["firstName"]. "</td>
                        <td>" . $row["email"]. "</td>
                        <td>" . $row["adressId"]. "</td>
                        <td>" . $row["street"]. "</td>
                        <td>" . $row["city"]. "</td>
                        <td>" . $row["country"]. "</td>
                        <td>" . $row["postalCode"]. "</td>
                        <td>" . $row["cardType"]. "</td>
                        <td>" . $row["cardNumber"]. "</td>
                        <td>" . $row["expirationDate"]. "</td>
                        <td>" . $row["cvv"]. "</td>
                        <td>
                            <a href='update_user.php?id=" . $row["userId"] . "'>Modifier utilisateur</a>
                            <a href='delete_user.php?id=" . $row["userId"] . "'>Supprimer utilisateur</a>
                            <a href='update_payment.php?id=" . $row["userId"] . "'>Modifier Paiement</a>
                            <a href='delete_payment.php?id=" . $row["userId"] . "'>Supprimer Paiement</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='14'>Aucun utilisateur trouvé</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <h1>Ajouter un produit</h1>
    <form action="create_product.php" method="post">
        <label for="name">Nom du produit:</label>
        <input type="text" id="name" name="name" required>
        <label for="price">Prix:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <label for="vendor">Vendeur:</label>
        <input type="text" id="vendor" name="vendor" required>
        <button type="submit">Ajouter</button>
    </form>

    <h1>Liste des produits</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Vendeur</th>
                <th>Photos</th>
                <th>Évaluations</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Lire les produits de la base de données
        $sql = "SELECT productId, name, price, vendor FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les produits
            while($row = $result->fetch_assoc()) {
                $productId = $row["productId"];

                // Récupérer les photos associées au produit
                $photoSql = "SELECT photoId, productId, image FROM photos WHERE productId='$productId'";
                $photoResult = $conn->query($photoSql);
                $photos = [];
                while ($photoRow = $photoResult->fetch_assoc()) {
                    $photos[] = '<div style="display:inline-block;position:relative;">
                                    <img src="data:image/jpeg;base64,' . base64_encode($photoRow['image']) . '" width="50" height="50"/>
                                    <a href="delete_photo.php?id=' . $photoRow['photoId'] . '" style="position:absolute;top:0;right:0;color:red;">X</a>
                                 </div>';
                }
                $photoHtml = implode(' ', $photos);

                // Récupérer les évaluations associées au produit
                $rateSql = "SELECT rateId, userId, productId, stars, comment FROM rates WHERE productId='$productId'";
                $rateResult = $conn->query($rateSql);
                $rates = [];
                while ($rateRow = $rateResult->fetch_assoc()) {
                    $rates[] = '<div>
                                    <strong>' . $rateRow['stars'] . ' étoiles</strong> - ' . $rateRow['comment'] . '
                                    <a href="update_rate.php?id=' . $rateRow['rateId'] . '">Modifier</a>
                                    <a href="delete_rate.php?id=' . $rateRow['rateId'] . '">Supprimer</a>
                                </div>';
                }
                $rateHtml = implode('<br>', $rates);

                echo "<tr>
                        <td>" . $row["productId"]. "</td>
                        <td>" . $row["name"]. "</td>
                        <td>" . $row["price"]. "</td>
                        <td>" . $row["vendor"]. "</td>
                        <td>" . $photoHtml . "</td>
                        <td>" . $rateHtml . "</td>
                        <td>
                            <a href='update_product.php?id=" . $row["productId"] . "'>Modifier</a>
                            <a href='delete_product.php?id=" . $row["productId"] . "'>Supprimer</a>
                            <a href='add_photo.php?id=" . $row["productId"] . "'>Ajouter Photo</a>
                            <a href='add_rate.php?id=" . $row["productId"] . "'>Ajouter Évaluation</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun produit trouvé</td></tr>";
        }

        ?>
        </tbody>
    </table>

    <h1>Ajouter une commande</h1>
    <form action="create_order.php" method="post">
        <label for="userId">ID Utilisateur:</label>
        <input type="number" id="userId" name="userId" required>
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" required>
        
        <label for="quantity">Quantité:</label>
        <input type="number" id="quantity" name="quantity" required>
        
        <button type="submit">Ajouter</button>
    </form>

    <h1>Liste des commandes</h1>
    <table>
        <thead>
            <tr>
                <th>ID Utilisateur</th>
                <th>ID Produit</th>
                <th>Date de Facture</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Lire les commandes de la base de données
        $sql = "SELECT invoiceId, userId, productId, invoiceDate, quantity, unitPrice,  total FROM invoices";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les commandes
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["userId"]. "</td>
                        <td>" . $row["productId"]. "</td>
                        <td>" . $row["invoiceDate"]. "</td>

                        <td>" . $row["quantity"]. "</td>
                        <td>" . $row["total"]. "</td>
                        <td>
                            <a href='update_order.php?id=" . $row["invoiceId"] . "'>Modifier</a>
                            <a href='delete_order.php?id=" . $row["invoiceId"] . "'>Supprimer</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucune commande trouvée</td></tr>";
        }

        ?>
        </tbody>
    </table>

    <h1>Liste des articles du panier</h1>
    <table>
        <thead>
            <tr>
                <th>ID Utilisateur</th>
                <th>ID Produit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php

        // Lire les articles du panier de la base de données
        $sql = "SELECT userId, productId FROM cart";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les articles du panier
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["userId"]. "</td>
                        <td>" . $row["productId"]. "</td>
                        <td>
                            <a href='update_cart.php?userId=" . $row["userId"] . "&productId=" . $row["productId"] . "'>Modifier</a>
                            <a href='delete_cart.php?userId=" . $row["userId"] . "&productId=" . $row["productId"] . "'>Supprimer</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Aucun article trouvé dans le panier</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</body>
</html>