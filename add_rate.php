<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une évaluation</title>
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

    <h1>Ajouter une évaluation</h1>
    <form action="create_rate.php" method="post">
        <label for="userId">ID Utilisateur:</label>
        <input type="number" id="userId" name="userId" required>
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" required>
        <label for="stars">Étoiles:</label>
        <input type="number" id="stars" name="stars" min="1" max="5" required>
        <label for="comment">Commentaire:</label>
        <textarea id="comment" name="comment" required></textarea>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>