# Pialoa Tech — Documentation & guide d'installation

Site vitrine + back-office développé avec **Laravel 13**, **Tailwind CSS** et
**MySQL**. Ce document couvre l'installation complète, la structure du projet,
la configuration, et les commandes utiles au quotidien.

---

## 1. Prérequis

> Laravel 13 (sorti le 17 mars 2026) n'introduit aucun changement cassant par
> rapport à Laravel 11/12 : les routes, `bootstrap/app.php`, contrôleurs et
> migrations de ce projet fonctionnent tels quels. La seule exigence
> supplémentaire est **PHP 8.3 minimum** (au lieu de 8.2 auparavant).

| Outil       | Version minimale | Vérifier avec        |
|-------------|-------------------|-----------------------|
| PHP         | **8.3**           | `php -v`              |
| Composer    | 2.x               | `composer -V`         |
| Node.js     | 18+               | `node -v`             |
| npm         | 9+                | `npm -v`               |
| MySQL       | 8.0 (ou MariaDB 10.6+) | `mysql --version` |

Extensions PHP nécessaires (généralement incluses par défaut) : `pdo_mysql`,
`mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`
(pour le traitement d'images).

---

## 2. Installation étape par étape

### 2.1 Créer le projet Laravel

L'archive fournie contient uniquement le **code applicatif** (contrôleurs,
modèles, vues, routes...), pas le noyau Laravel ni le dossier `vendor/`. On
part donc d'une installation Laravel neuve, puis on copie ces fichiers
par-dessus.

```bash
composer create-project laravel/laravel pialoatech-app
cd pialoatech-app
```

### 2.2 Copier les fichiers du projet

Décompressez `pialoatech-laravel.zip`, puis copiez son contenu dans le dossier
`pialoatech-app` créé à l'étape précédente (en écrasant les fichiers
existants : `composer.json`, `package.json`, `routes/web.php`,
`bootstrap/app.php`, etc.) :

```bash
cp -r /chemin/vers/pialoatech/* /chemin/vers/pialoatech-app/
cp -r /chemin/vers/pialoatech/.gitignore /chemin/vers/pialoatech-app/
```

### 2.3 Installer les dépendances

```bash
composer install
npm install
```

### 2.4 Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Ouvrez `.env` et renseignez vos accès MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pialoatech
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

Créez ensuite la base de données :

```bash
mysql -u root -p -e "CREATE DATABASE pialoatech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 2.5 Lien de stockage public

**Étape obligatoire** : sans elle, les images de produits/événements, les
avatars de stagiaires et les documents ne s'afficheront pas.

```bash
php artisan storage:link
```

Cette commande crée un lien symbolique `public/storage` pointant vers
`storage/app/public`, où sont enregistrés tous les fichiers uploadés.

### 2.6 Migrations et données de démonstration

```bash
php artisan migrate --seed
```

Cela crée toutes les tables (`users`, `produits`, `services`, `evenements`,
`stagiaires`, ...) et insère :
- un compte administrateur (voir section 4)
- 8 services, 2 produits et 1 événement de démonstration

Si vous voulez repartir de zéro sans les données de démo :

```bash
php artisan migrate:fresh
php artisan db:seed --class=AdminUserSeeder   # crée uniquement l'admin
```

### 2.7 Lancer le projet en local

Deux terminaux sont nécessaires :

```bash
# Terminal 1 — serveur PHP
php artisan serve

# Terminal 2 — compilation Tailwind/JS en continu
npm run dev
```

Rendez-vous sur **http://localhost:8000**. L'espace admin est accessible via
le bouton "Espace admin" du menu, ou directement sur `/login`.

---

## 3. Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php        Accueil + À propos
│   │   ├── ProduitController.php     Liste publique des produits
│   │   ├── ServiceController.php     Liste publique des services
│   │   ├── EvenementController.php   Liste + détail des actualités
│   │   ├── Auth/LoginController.php  Connexion / déconnexion
│   │   └── Admin/                    Contrôleurs CRUD du back-office
│   │       ├── DashboardController.php
│   │       ├── ProduitController.php
│   │       ├── ServiceController.php
│   │       ├── EvenementController.php
│   │       └── StagiaireController.php
│   └── Middleware/
│       └── AdminMiddleware.php       Bloque l'accès admin aux non-admins
├── Models/
│   ├── User.php          Comptes admin (champ "role")
│   ├── Produit.php
│   ├── Service.php
│   ├── Evenement.php
│   └── Stagiaire.php

database/
├── migrations/            5 migrations (users, produits, services, evenements, stagiaires)
└── seeders/
    ├── DatabaseSeeder.php     Point d'entrée, appelle les autres seeders
    └── AdminUserSeeder.php    Crée le compte admin par défaut

resources/
├── views/
│   ├── layouts/app.blade.php     Layout public (navbar + footer)
│   ├── layouts/admin.blade.php   Layout admin (sidebar + header)
│   ├── partials/                 Navbar, footer
│   ├── home.blade.php, about.blade.php
│   ├── produits/, services/, evenements/    Pages publiques
│   ├── auth/login.blade.php
│   └── admin/                    Tableau de bord + CRUD (produits, services, evenements, stagiaires)
├── css/app.css            Design tokens Tailwind (couleurs, boutons, cartes)
└── js/app.js               Menu mobile + config Axios

routes/
├── web.php        Toutes les routes (publiques, auth, admin)
└── console.php

public/images/      Logo et visuel de démonstration
```

---

## 4. Comptes et accès

### Administrateur par défaut

| Champ         | Valeur                    |
|---------------|----------------------------|
| E-mail        | `admin@pialoatech.com`     |
| Mot de passe  | `ChangeMoi123!`             |

⚠️ **À changer avant toute mise en ligne.** Deux façons de le faire :

**Option A — via Tinker** :
```bash
php artisan tinker
>>> $u = App\Models\User::where('email', 'admin@pialoatech.com')->first();
>>> $u->password = 'NouveauMotDePasseSolide!';
>>> $u->save();
```

**Option B — modifier le seeder** (`database/seeders/AdminUserSeeder.php`)
avant le premier `migrate --seed`, puis relancer.

### Créer un second compte admin

```bash
php artisan tinker
>>> App\Models\User::create([
...     'name' => 'Nouvel Admin',
...     'email' => 'nouveladmin@pialoatech.com',
...     'password' => 'MotDePasseSolide!',
...     'role' => 'admin',
... ]);
```

---

## 5. Gestion des fichiers uploadés

Tous les fichiers (images de produits/événements, avatars, documents) sont
stockés dans `storage/app/public/...` et servis via le lien symbolique
`public/storage` créé à l'étape 2.5.

| Type de fichier          | Dossier                          | Règles de validation                     |
|---------------------------|-----------------------------------|--------------------------------------------|
| Image produit              | `storage/app/public/produits`     | image, 2 Mo max                            |
| Image événement            | `storage/app/public/evenements`   | image, 2 Mo max                            |
| Document événement         | `storage/app/public/documents`    | PDF/DOC/DOCX, 5 Mo max                     |
| Avatar stagiaire            | `storage/app/public/avatars`      | image, 2 Mo max                            |

En cas de modification ou suppression d'une fiche, l'ancien fichier est
automatiquement supprimé du disque (voir les contrôleurs `Admin/*Controller.php`).

---

## 6. Commandes artisan utiles

```bash
php artisan route:list                 # Lister toutes les routes
php artisan migrate:status             # État des migrations
php artisan migrate:rollback           # Annuler la dernière migration
php artisan make:controller NomController
php artisan make:model NomModele -m    # Modèle + migration
php artisan tinker                     # Console interactive (tester des requêtes Eloquent)
php artisan optimize:clear             # Vider tous les caches (config, routes, vues)
```

---

## 7. Déploiement en production

1. **Variables d'environnement** : sur le serveur, définir
   `APP_ENV=production` et `APP_DEBUG=false` dans `.env` (ne jamais laisser
   `APP_DEBUG=true` en production : cela expose des informations sensibles).
2. **Build des assets** :
   ```bash
   npm run build
   ```
   (remplace `npm run dev`, génère les fichiers optimisés dans `public/build`)
3. **Optimisations Laravel** :
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan storage:link
   php artisan migrate --force
   ```
4. **Permissions** : les dossiers `storage/` et `bootstrap/cache/` doivent
   être accessibles en écriture par le serveur web (utilisateur `www-data`
   sur la plupart des configurations Apache/Nginx).
5. **HTTPS** : configurez un certificat SSL (Let's Encrypt par exemple) et
   pointez `APP_URL` vers l'URL finale en `https://`.

---

## 8. Dépannage (erreurs fréquentes)

| Symptôme                                                     | Cause probable                                   | Solution                                              |
|----------------------------------------------------------------|----------------------------------------------------|----------------------------------------------------------|
| Page blanche ou erreur 500                                     | `APP_KEY` manquante                                 | `php artisan key:generate`                                |
| Images/avatars ne s'affichent pas                              | Lien de stockage non créé                          | `php artisan storage:link`                                |
| `SQLSTATE[HY000] [1049] Unknown database`                     | Base de données non créée                          | Créer la base MySQL `pialoatech` avant `migrate`          |
| Styles Tailwind absents (page non stylée)                     | Assets non compilés                                 | `npm run dev` (local) ou `npm run build` (production)     |
| `419 Page Expired` en soumettant un formulaire                | Session expirée / cookies bloqués                  | Rafraîchir la page et recommencer ; vérifier `SESSION_DRIVER` |
| Impossible de se connecter en admin                             | Mauvais identifiants ou seeder non exécuté         | `php artisan db:seed --class=AdminUserSeeder`              |
| Erreur lors de l'upload d'un fichier                             | Fichier trop volumineux                             | Vérifier `upload_max_filesize` et `post_max_size` dans `php.ini` |

---

## 9. Aller plus loin

Idées d'évolutions pour la suite du projet :
- Espace de connexion dédié aux stagiaires (leur fiche est actuellement
  gérée uniquement par l'admin)
- Gestion de rôles multiples (le champ `role` existe déjà sur la table `users`)
- Recherche et filtres sur les listes admin (par secteur, par date...)
- Notification e-mail automatique lors de la publication d'un nouvel événement
- Pagination/tri configurable sur les listes publiques
