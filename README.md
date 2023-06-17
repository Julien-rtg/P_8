# To Do List app

## A propos

To Do List app est une application qui permet de gérer ses tâches quotidiennes.

## Versions utilisées

- Version utilisé avec symfony pour ce projet PHP 8.1.11
- Version de symfony 5.4.10
- Symfony CLI version 5.5.2

## Mise en place de l'environnement de travail

- Installez le gestionnaire de versions de fichiers GIT [https://git-scm.com/downloads](https://git-scm.com/downloads)
- Installez l'environnement de développement pour PHP et MySQL sur votre ordinateur avec WAMP [https://www.apachefriends.org/fr/index.html](https://www.apachefriends.org/fr/index.html)
- Installez le gestionnaire de dépendances de PHP : composer [https://getcomposer.org/download/](https://getcomposer.org/download/)
- Installez l'interpréteur de commandes symfony (CLI Symfony)

### Testez votre configuration

1. Ouvrez	votre terminal
2. Tapez	la commande **git** et	assurez vous qu'il n'y a pas de message d'erreur particulier
3. Tapez	la commande **php	-v** et	assurez vous que vous avez la version 7.4.3 au minimum
4. Tapez	la commande **composer -v** et assurez vous qu'il n'y a pas de message d'erreur particulier

## Installation projet

### Cloner le dépôt git distant en local

Dans votre terminal, positionnez vous dans le bon répertoire est cloner le dépot git en local

```
git clone https://github.com/Julien-rtg/P_8.git
```

### Installer les dépendances

Installer les dépendances avec composer à partir du fichier composer.lock

```
composer install
```

### Paramétrer les variables d'environnement

- Dupliquer le fichier .env et renommé le .env.local
- Dans l’arborescence du projet rendez vous dans le fichier .env.local
- les réglages qui vont y être fait seront pour une configuration en local:
- Utilisation de wamp comme serveur pour la base de donnée en SQL avec utilisation de phpmyadmin
- L'adresse de l'application sera [http://127.0.0.1:8000](http://127.0.0.1:8000/)

Dans le fichier .env.local penser à commenté la ligne concernant le postgresql et décommenté la ligne mysql au dessus

Sur la ligne MySQL rentrer les informations de la manière suivante

DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8&charset=utf8mb4"

- db_user : entrée un identifiant pour l'accés à la base de donnée
- db_password : entrée mot de passe
- db_name : entrée le nom de la base de donnée par exemple api-bilemo

Enregistrez le fichier .env.local

### Création de la base de donnée

1-Lancer l'application Wamp démarrer les modules Apach et MySQL
2-sur wamp ouvrir la page de phpmyadmin en cliquant sur admin

Dans votre terminal

```
php bin/console doctrine:database:create
```

Cette commande va créer la base de donnée en récupérant le nom que nous avons donnés dans le fichier .env.local
Rafraîchir la page de phpmyadmin, P8 doit apparaître dans l'arborescence

### Jouer les migrations pour créer les tables dans la base de données

Tapez la commande dans votre terminal

```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

A la question "Êtes-vous sûr de vouloir continuer d'éxecuté la migration dans la base de données "P8" ? répondre oui

Rafraichir la page de phpmyadmin, la liste des tables doit apparaître dans la base de donnée.

### Charger les fixtures pour alimenter de données les tables

Dans votre terminal

```
php bin/console doctrine:fixtures:load 
```

Cela aura pour effet de créer un jeu de fausses données.
A la question répondre oui.
Rafraichir la page de phpmyadmin, les fausses données doivent apparaître.

### Pour réaliser les tests il faut générer cette commandes

Dans votre terminal

```
vendor/bin/phpunit --coverage-html public/test-coverage
```



### Chargement de To Do List app

1-Lancer le serveur

Dans votre terminal

```
symfony server:start
```

2- Tapez dans la barre d'url de votre navigateur

[http://127.0.0.1:8000]


3- Pour arrêter le serveur

```
symfony server:stop
```

### Rappel

Avant le lancement de l'application n'oublié pas au préalable de lancer les modules de wamp.
