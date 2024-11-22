<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un paiement</title>
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

    <h1>Ajouter un paiement</h1>
    <form action="create_payment.php" method="post">
        <label for="userId">ID Utilisateur:</label>
        <input type="number" id="userId" name="userId" required>
        <label for="cardType">Type de carte:</label>
        <input type="text" id="cardType" name="cardType" required>
        <label for="cardNumber">Numéro de carte:</label>
        <input type="text" id="cardNumber" name="cardNumber" required>
        <label for="expirationDate">Date d'expiration:</label>
        <input type="text" id="expirationDate" name="expirationDate" required>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>