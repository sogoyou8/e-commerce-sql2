<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

    <div class="navbar">
        <a href="index.php">Accueil</a>
        <a href="add_user.php">Ajouter Utilisateur</a>
        <a href="add_product.php">Ajouter Produit</a>
        <a href="add_photo.php">Ajouter Photo</a>
        <a href="add_rate.php">Ajouter Évaluation</a>
        <a href="add_payment.php">Ajouter Paiement</a>
        <a href="add_to_cart.php">Ajouter au Panier</a>
        <a href="index.php">Retour à l'accueil</a>
    </div>

    <h1>Ajouter un utilisateur</h1>
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
</body>
</html>