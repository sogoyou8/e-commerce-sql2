<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une photo</title>
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

    <h1>Ajouter une photo</h1>
    <form action="create_photo.php" method="post" enctype="multipart/form-data">
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" required>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>