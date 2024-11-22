<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
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

    <h1>Ajouter un produit</h1>
    <form action="create_product.php" method="post">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required>
        <label for="price">Prix:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <label for="vendor">Vendeur:</label>
        <input type="text" id="vendor" name="vendor" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>