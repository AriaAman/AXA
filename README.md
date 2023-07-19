# Test technique Symfony pour RUN Services

Ce projet a été réalisé dans le cadre d'un test technique pour RUN Services en environ 2h30. Il a été développé en utilisant Symfony 5.4.2 dans un environnement Docker avec une base de données MariaDB.

## Installation et configuration

Pour mettre en place le projet, suivez les étapes suivantes :

1. Cloner le projet.
2. Lancer Docker et créer les conteneurs correspondants.
3. Installer les dépendances PHP avec Composer.
4. Effectuer les migrations pour générer les tables de la base de données :

```php
php bin/console doctrine:migrations:migrate
```

Pour ajouter la table projets faite la commande suivante :

```php
php bin/console doctrine:migrations:diff
```

## Fonctionnalités

### Gestion des utilisateurs

Les utilisateurs peuvent s'inscrire et se connecter. Ces fonctionnalités ont été mises en place avec l'aide de la commande `php bin/console make:auth`.

(Pour la création d'un compte, `php bin/console make:registration`)

### Gestion des projets

Les utilisateurs peuvent créer des projets, leur attribuer un nom, une description, une date de début et une date de fin. Ils peuvent également inviter d'autres utilisateurs à rejoindre leurs projets en tant que membres. Cette fonctionnalité n'est pas couverte par les migrations et nécessite une migration diff.
