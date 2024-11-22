<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une photo</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
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