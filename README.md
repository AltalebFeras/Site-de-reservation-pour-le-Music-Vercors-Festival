# Site-de-r-servation-pour-le-Music-Vercors-Festival


README - Formulaire de Réservation avec MVC.

Ce projet est une application de réservation développée en utilisant le modèle MVC (Modèle-Vue-Contrôleur) avec PHP, MySQL et JavaScript. Le but de ce document est de fournir des instructions pour l'installation, la configuration et l'utilisation de l'application.

Développement.

Architecture MVC.

L'application suit le modèle MVC (Modèle-Vue-Contrôleur) pour assurer une séparation claire des responsabilités :

Modèle: Le modèle est responsable de l'accès aux données et de leur manipulation. Les modèles interagissent avec la base de données pour récupérer et stocker les données.

Vue: La vue est responsable de l'interface utilisateur. Elle affiche les données au format approprié et récupère les entrées de l'utilisateur.

Contrôleur: Le contrôleur agit comme un intermédiaire entre le modèle et la vue. Il récupère les entrées de l'utilisateur depuis la vue, traite les actions demandées, et communique avec le modèle pour effectuer les opérations sur les données.


Structure du Projet.

index.php: Le point d'entrée de l'application. C'est là où la vue est affichée et où les contrôleurs sont appelés.

config/database.php: Fichier de configuration contenant les paramètres de connexion à la base de données.

controllers/: Ce répertoire contient les contrôleurs de l'application.

models/: Ce répertoire contient les modèles de données utilisés par l'application.

views/: Ce répertoire contient les fichiers de vue utilisés pour afficher l'interface utilisateur.

assets/: Ce répertoire contient les fichiers statiques tels que les fichiers CSS, JavaScript, etc.


Sécurité.

Il est essentiel de maintenir la sécurité de l'application. Voici quelques mesures de sécurité à prendre en compte :

Validation des données: Toujours valider les données côté client et côté serveur pour éviter les attaques par injection de code malveillant.

Protection contre les attaques XSS: Échapper les données affichées dans les vues pour éviter les attaques par injection de scripts.

Protection contre les injections SQL: Utiliser des requêtes préparées ou des fonctions d'échappement pour éviter les injections SQL.


Rôles Utilisateur et Administrateur.

Dans ce projet, deux rôles principaux sont définis : utilisateur et administrateur.

Utilisateur : Les utilisateurs peuvent accéder à l'interface de réservation, soumettre de nouvelles réservations et afficher les réservations existantes. Ils ont des fonctionnalités limitées par rapport aux administrateurs.

Administrateur : Les administrateurs ont un accès étendu à l'application. Ils peuvent non seulement effectuer toutes les actions d'un utilisateur standard, mais aussi gérer les réservations existantes, ajouter de nouveaux utilisateurs, modifier les paramètres système, etc.

Gestion des Rôles.
L'attribution des rôles est gérée dans la base de données. Chaque utilisateur est associé à un rôle spécifique, qui détermine ses privilèges dans l'application.

Création d'un nouvel Utilisateur.
Lorsqu'un nouvel utilisateur est ajouté à l'application, un administrateur peut définir son rôle en tant qu'utilisateur ou administrateur.

Authentification et Autorisation
L'authentification est le processus par lequel les utilisateurs sont identifiés en fonction de leurs informations d'identification (nom d'utilisateur et mot de passe). Une fois authentifiés, l'autorisation détermine les actions spécifiques qu'un utilisateur est autorisé à effectuer en fonction de son rôle.

Fonctionnalités Administratives.

Les fonctionnalités administratives incluent, mais ne se limitent pas à :

Gestion des utilisateurs : Ajout, modification et suppression des comptes utilisateur.

Gestion des réservations : Affichage, modification et suppression des réservations existantes.

Configuration système : Modification des paramètres de l'application, gestion des préférences, etc.

Sécurité des Rôles.

Il est essentiel de maintenir la sécurité des rôles dans l'application. Voici quelques mesures de sécurité à prendre en compte :

Assurer que seuls les utilisateurs autorisés ont accès aux fonctionnalités administratives.

Limiter les accès des utilisateurs en fonction de leur rôle pour éviter les abus de privilèges.


Ce projet a été développé par Feras Altaleb et Arthur Zulpukharov.