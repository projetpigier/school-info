# PIGIER School Info - Application de Diffusion d'Informations

Application web Laravel dockerisée permettant de diffuser des messages et informations à l'endroit des étudiants de l'établissement PIGIER.

## Description du Projet

Cette application répond aux problématiques suivantes:
- Les étudiants ne reçoivent pas les annonces d'ordre général venant de l'administration
- Les étudiants distants n'ont pas accès aux informations affichées par l'administration
- Les étudiants ne reçoivent pas les informations urgentes sur la disponibilité d'un enseignement ou changement de salle à temps

## Fonctionnalités

### Pour l'Administration
- Publier des annonces générales
- Alerter les étudiants sur les changements de salle
- Alerter sur la disponibilité d'un enseignement
- Envoyer les emplois du temps
- Gérer les alertes de retards/incidents de paiement de scolarité

### Pour les Enseignants
- Consulter leur emploi du temps
- Envoyer les notes individuelles de chaque étudiant
- Recevoir leur emploi du temps

### Pour les Étudiants
- Afficher leur emploi du temps
- Consulter leurs notes
- Recevoir les annonces et alertes
- Consulter l'état de leurs paiements

## Technologies Utilisées

- **Backend**: Laravel 12 (PHP 8.2)
- **Frontend**: Blade Templates + Tailwind CSS
- **Base de données**: MySQL 8.0
- **Cache/Queue**: Redis
- **Mail Testing**: MailHog
- **Containerisation**: Docker & Docker Compose
- **Serveur Web**: Nginx

## Prérequis

- Docker Desktop (version 20.10 ou supérieure)
- Docker Compose (version 2.0 ou supérieure)
- Git

## Installation et Déploiement

### 1. Cloner le repository

```bash
git clone https://github.com/projetpigier/school-info.git
cd school-info
```

### 2. Démarrer l'application avec Docker

```bash
# Construire et démarrer les conteneurs
docker-compose up -d --build
```

Cette commande va:
- Construire l'image Docker de l'application
- Démarrer MySQL, Redis et MailHog
- Installer les dépendances PHP et Node.js
- Configurer l'application

### 3. Accéder au conteneur et configurer la base de données

```bash
# Entrer dans le conteneur de l'application
docker-compose exec app bash

# Exécuter les migrations
php artisan migrate

# Charger les données de test
php artisan db:seed

# Sortir du conteneur
exit
```

### 4. Accéder à l'application

L'application sera accessible à l'adresse: **http://localhost:8080**

### Services Disponibles

- **Application Web**: http://localhost:8080
- **MailHog (Test d'emails)**: http://localhost:8025
- **MySQL**: localhost:3306
- **Redis**: localhost:6379

## Comptes de Test

Après avoir exécuté le seeder, vous pouvez vous connecter avec les comptes suivants:

### Administrateur
- Email: `admin@pigier.com`
- Mot de passe: `password`

### Enseignant
- Email: `jean.dupont@pigier.com`
- Mot de passe: `password`

### Étudiant
- Email: `etudiant@pigier.com`
- Mot de passe: `password`

## Structure de la Base de Données

### Tables Principales

- **users**: Utilisateurs (admin, enseignants, étudiants)
- **announcements**: Annonces et messages
- **schedules**: Emplois du temps
- **grades**: Notes des étudiants
- **payments**: Paiements de scolarité
- **notifications**: Notifications utilisateurs

## Commandes Docker Utiles

```bash
# Démarrer les conteneurs
docker-compose up -d

# Arrêter les conteneurs
docker-compose down

# Voir les logs
docker-compose logs -f

# Reconstruire les conteneurs
docker-compose up -d --build

# Accéder au conteneur de l'application
docker-compose exec app bash

# Exécuter des commandes artisan
docker-compose exec app php artisan [commande]
```

## Développement

### Exécuter les migrations

```bash
docker-compose exec app php artisan migrate
```

### Créer une nouvelle migration

```bash
docker-compose exec app php artisan make:migration create_table_name
```

### Créer un contrôleur

```bash
docker-compose exec app php artisan make:controller ControllerName
```

### Rafraîchir la base de données

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### Compiler les assets

```bash
docker-compose exec app npm run dev
```

## Architecture de l'Application

```
school-info/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Contrôleurs
│   │   └── Middleware/       # Middleware (CheckRole)
│   └── Models/               # Modèles Eloquent
├── database/
│   ├── migrations/           # Migrations de base de données
│   └── seeders/             # Seeders pour données de test
├── resources/
│   └── views/               # Vues Blade
├── routes/
│   └── web.php              # Routes web
├── docker/
│   ├── nginx/               # Configuration Nginx
│   └── supervisor/          # Configuration Supervisor
├── docker-compose.yml       # Orchestration Docker
├── Dockerfile              # Image Docker
└── README.md
```

## Système de Rôles

L'application utilise un système de rôles avec middleware:

- **Admin**: Accès complet (gestion annonces, emplois du temps, paiements)
- **Teacher**: Gestion des notes, consultation emploi du temps
- **Student**: Consultation notes, emploi du temps, paiements

## Dépannage

### Problème de permissions

```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Réinitialiser complètement l'application

```bash
docker-compose down -v
docker-compose up -d --build
docker-compose exec app php artisan migrate:fresh --seed
```

### Problème de connexion à la base de données

Vérifiez que le conteneur MySQL est bien démarré:
```bash
docker-compose ps
```

## Sécurité

- Les mots de passe sont hashés avec bcrypt
- Protection CSRF activée sur tous les formulaires
- Middleware d'authentification pour toutes les routes protégées
- Middleware de vérification des rôles

## Performance

- Cache Redis pour les sessions et le cache applicatif
- Queue Redis pour les tâches asynchrones
- Optimisation des requêtes Eloquent avec eager loading

## Contribuer

1. Créer une branche pour votre fonctionnalité
2. Commiter vos changements
3. Pousser vers la branche
4. Créer une Pull Request

## Support

Pour toute question ou problème, veuillez ouvrir une issue sur GitHub.

## Auteurs

Projet développé par le groupe d'étudiants PIGIER dans le cadre du module de développement web.

## Licence

Ce projet est développé dans un cadre éducatif pour l'établissement PIGIER.

---

**Note**: Cette application est un projet éducatif et peut nécessiter des ajustements pour une utilisation en production.
