<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un article au panier</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h1>Ajouter un article au panier</h1>
    <form action="create_cart.php" method="post">
        <label for="userId">ID Utilisateur:</label>
        <input type="number" id="userId" name="userId" required>
        <label for="productId">ID Produit:</label>
        <input type="number" id="productId" name="productId" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>