# E-commerce SQL Project

## Description
Ce projet consiste à développer une base de données pour un site e-commerce. Il inclut la génération de données fictives pour les utilisateurs, produits, commandes, factures, avis et paniers, à l'aide d'un script PHP. Ce projet est conçu pour gérer les aspects essentiels d'un site de commerce en ligne en utilisant une base de données SQL.

## Structure du projet
### Dossiers :
- **/images** : Contient les images.png de l'affichage et la gestion des tables de la base de données.

### Fichiers :
- **Ecommerce_db.sql** : Contient le fichier SQL pour la création et la gestion des tables de la base de données.
- **style.css** : Contient le fichier CSS pour le style de l'interface HTML.
- **index.php** : Contient le script principal pour l'affichage et la gestion des données.
- **add_user.php** : Formulaire pour ajouter un utilisateur.
- **create_user.php** : Script pour ajouter un utilisateur.
- **update_user.php** : Script pour mettre à jour un utilisateur.
- **delete_user.php** : Script pour supprimer un utilisateur.
- **add_product.php** : Formulaire pour ajouter un produit.
- **create_product.php** : Script pour ajouter un produit.
- **update_product.php** : Script pour mettre à jour un produit.
- **delete_product.php** : Script pour supprimer un produit.
- **add_photo.php** : Formulaire pour ajouter une photo.
- **create_photo.php** : Script pour ajouter une photo.
- **update_photo.php** : Script pour mettre à jour une photo.
- **delete_photo.php** : Script pour supprimer une photo.
- **add_rate.php** : Formulaire pour ajouter une évaluation.
- **create_rate.php** : Script pour ajouter une évaluation.
- **update_rate.php** : Script pour mettre à jour une évaluation.
- **delete_rate.php** : Script pour supprimer une évaluation.
- **add_payment.php** : Formulaire pour ajouter un paiement.
- **create_payment.php** : Script pour ajouter un paiement.
- **update_payment.php** : Script pour mettre à jour un paiement.
- **delete_payment.php** : Script pour supprimer un paiement.
- **add_to_cart.php** : Formulaire pour ajouter un article au panier.
- **create_cart.php** : Script pour ajouter un article au panier.
- **update_cart.php** : Script pour mettre à jour un article du panier.
- **delete_cart.php** : Script pour supprimer un article du panier.
- **delete_order.php** : Script pour supprimer une commande.

### Tables de la base de données :
- `users` : Informations des utilisateurs (nom, email, mot de passe sécurisé, etc.).
- `adresses` : Adresses associées aux utilisateurs.
- `products` : Liste des produits avec prix et fournisseur.
- `photos` : Images associées aux produits.
- `rates` : Avis des utilisateurs sur les produits.
- `cart` : Produits ajoutés au panier des utilisateurs.
- `invoices` : Factures des utilisateurs pour leurs achats.
- `orders` : Commandes associées aux factures.

## Technologies utilisées
- **PHP** : Utilisé pour générer les données fictives et interagir avec la base de données.
- **MySQL** : Base de données pour stocker les informations des utilisateurs, produits, commandes, etc.
- **CSS** : Utilisé pour styliser l'interface HTML affichant les données générées.
- **Git** : Gestion de versions.

## Installation
### Prérequis :
- **XAMPP** ou un autre serveur local pour exécuter PHP et MySQL.
- **Git** pour la gestion des versions.
- **Composer** pour gérer les dépendances PHP.


### Étapes :
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/sogoyou8/e-commerce-sql2.git
