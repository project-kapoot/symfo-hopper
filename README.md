# project-kapoot 🎮

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=project-kapoot_symfo-hopper&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=project-kapoot_symfo-hopper)

## 📋 Description

Quiz Game est une application web inspirée de Kahoot permettant de créer et participer à des quiz interactifs en temps réel. Développée avec Symfony 7.2, cette plateforme offre une expérience ludique et engageante pour l'apprentissage et l'évaluation des connaissances, utilisable en mode solo ou multijoueur.

## 📚 Documentation

La documentation complète du projet est disponible [ici📋](https://project-kapoot.github.io/symfo-hopper/).

## ✨ Fonctionnalités

- **Création de quiz** : Interface intuitive pour créer des questionnaires personnalisés avec logo et description
- **Mode multijoueur** : Sessions en temps réel avec plusieurs participants
- **Mode solo** : Entraînement individuel sur les quiz disponibles
- **Gestion des présentateurs** : Possibilité d'assigner un présentateur à une session
- **Tableaux de scores** : Classement dynamique des participants avec calcul de score
- **Chronomètre par question** : Configuration du délai de réponse pour chaque question
- **Système de points flexible** : Configuration des scores minimum et maximum pour chaque question
- **Explications des réponses** : Possibilité d'ajouter des explications pour chaque question
- **Historique des réponses** : Suivi des réponses et des scores de chaque utilisateur
- **Classement global** : Score cumulatif pour les utilisateurs à travers toutes les sessions

## 🔧 Prérequis techniques

- PHP 8.2 ou supérieur
- Symfony 7.2
- Base de données compatible avec Doctrine (PostgreSQL recommandé, MySQL/MariaDB supportés)
- Composer
- Serveur web (Nginx/Apache)

## 🚀 Installation

### Méthode standard

1. **Cloner le dépôt**
```bash
git clone https://github.com/project-kapoot/symfo-hopper.git
cd symfo-hopper
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Configurer la base de données**

Copier le fichier `.env` en `.env.local` et configurer votre connexion à la base de données :
```
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:2345/app?serverVersion=16&charset=utf8"
# Alternative pour MySQL
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
```

4. **Créer la base de données et exécuter les migrations**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Charger les fixtures (données de test - optionnel)**
```bash
php bin/console doctrine:fixtures:load
```

6. **Configurer les assets**
```bash
php bin/console importmap:install
```

7. **Lancer le serveur de développement**
```bash
symfony serve
```

L'application est maintenant accessible à l'adresse `http://localhost:8000`

### Méthode avec Docker

```bash
# Cloner le projet
git clone https://github.com/project-kapoot/symfo-hopper.git
cd symfo-hopper

# Lancer avec Docker
docker compose up -d

# Accès:
# - Application: http://localhost
# - Adminer (DB): http://localhost:8080
# - Mailpit: http://localhost:8025
```

## 🛠️ Tests

Pour exécuter les tests (nécessite PHPUnit) :

```bash
php bin/phpunit
```

## 🔍 Développement

### Commandes utiles

```bash
# Créer une nouvelle entité
php bin/console make:entity

# Créer une migration après modification des entités
php bin/console make:migration

# Créer un nouveau contrôleur
php bin/console make:controller

# Voir toutes les routes disponibles
php bin/console debug:router
```

## 🤝 Contribution

Pour contribuer au projet :

1. Créez une branche à partir de `develop` avec une convention de nommage appropriée
   - `feature/` pour les nouvelles fonctionnalités
   - `fix/` pour les corrections de bugs
   - `docs/` pour la documentation

> **Important** : Pour les modifications du README, utilisez spécifiquement la branche `docs/readme` afin de ne pas déclencher le workflow `deploy.yml`.