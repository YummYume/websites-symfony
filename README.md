# Projet Symfony

## Contexte

Ce projet consiste à avoir une liste de sites avec leurs clients.

L'utilisateur peut :
- Ajouter un client
- Ajouter un site
- Consulter les sites et leurs clients
- Rechercher un site par son nom
- ~~Contempler un magnifique background~~

## Technologies utilisées

- Symfony 5.4.0
- Bootstrap 4.0

## Comment installer & booter le projet

- Cloner le projet
- Modifier le fichier .env pour mettre sa propre base de données locale
- Effectuer les commandes suivantes :
```
composer install
php bin/console d:m:m
php bin/console d:f:l
symfony server:start
```
- Se rendre sur <a href="http://localhost:8000/" target="_blank">localhost</a>
