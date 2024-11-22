<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
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