# Touche pas au klaxon

Application intranet de covoiturage inter-sites développée en PHP avec une architecture MVC.

## Prérequis

- PHP >= 8.1
- MySQL ou MariaDB
- Composer
- XAMPP (ou serveur Apache + PHP local)

## Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/PepitoDsgn/touche-pas-au-klaxon
cd touche-pas-au-klaxon
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Créer la base de données

Dans phpMyAdmin ou via le terminal MySQL :

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
```

### 4. Configurer la base de données

Copiez le fichier d'environnement et modifiez-le :

```bash
cp .env.example .env
```

Puis modifiez `.env` avec vos identifiants MySQL.

### 5. Configurer le serveur web

**Avec XAMPP :** placez le projet dans `htdocs/`, puis accédez à `http://localhost/touche-pas-au-klaxon`.

**Avec le serveur interne PHP :**

```bash
cd public
php -S localhost:8000
```

Puis ouvrez `http://localhost:8000`.

## Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Utilisateur | `alexandre.martin@email.fr` | `Password1!` |
| Administrateur | `admin@klaxon.fr` | `Admin1234!` |

## Lancer les tests

```bash
./vendor/bin/phpunit
```

## Structure du projet

```
touche-pas-au-klaxon/
├── public/               ← Point d'entrée web
│   ├── index.php
│   └── assets/
│       ├── css/main.css
│       ├── scss/main.scss
│       └── js/main.js
├── src/
│   ├── Core/             ← Router, Database, Session, Controller (base)
│   ├── Controllers/      ← HomeController, AuthController, TrajetController, AdminController
│   ├── Models/           ← Model (base), UserModel, AgenceModel, TrajetModel
│   └── Views/            ← Templates PHP
├── database/
│   ├── schema.sql        ← Création des tables
│   └── seed.sql          ← Jeu d'essais
├── tests/
│   └── TrajetValidationTest.php
├── composer.json
└── phpunit.xml
```

## Fonctionnalités

- **Visiteur** : liste des trajets disponibles (places > 0, date future)
- **Utilisateur connecté** : voir les détails d'un trajet (modale), créer / modifier / supprimer ses propres trajets
- **Administrateur** : gérer les utilisateurs, les agences (CRUD) et les trajets (suppression)
