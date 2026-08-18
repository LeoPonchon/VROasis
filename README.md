# VROasis

Projet e-commerce fictif consacré aux produits de **réalité virtuelle**, développé avec **Symfony 7** dans un contexte pédagogique.

L'application met en pratique l'authentification, un catalogue, un panier, les commandes et l'administration d'une boutique web.

## Fonctionnalités

- inscription et authentification ;
- catalogue de produits VR ;
- panier ;
- passage de commandes ;
- gestion des produits ;
- gestion des commandes ;
- espace/tableau de bord administratif.

## Stack

- PHP **8.2+**
- Symfony **7.0**
- Doctrine ORM / DBAL
- Twig
- Symfony Security
- Symfony AssetMapper / UX
- PHPUnit

> Le projet exige PHP 8.2 ou plus via `composer.json`.

## Installation

```bash
git clone https://github.com/LeoPonchon/VROasis.git
cd VROasis
composer install
```

Configurez ensuite votre environnement local dans `.env.local`, notamment `DATABASE_URL`.

Exemple de workflow Doctrine selon votre environnement :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Si le projet ne contient pas encore de migration correspondant à votre base, adaptez cette étape à l'état du schéma.

## Lancer l'application

Avec Symfony CLI :

```bash
symfony server:start
```

Ou avec le serveur PHP intégré :

```bash
php -S localhost:8000 -t public
```

Puis ouvrez :

```text
http://localhost:8000
```

## Tests

```bash
php bin/phpunit
```

## Contexte

VROasis est un projet éducatif : les produits et scénarios de commerce sont fictifs et servent à démontrer la construction d'une application Symfony complète.
