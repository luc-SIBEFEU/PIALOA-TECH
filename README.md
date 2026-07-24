> 📖 Pour l'installation détaillée, la structure du projet, le dépannage et
> le déploiement en production, voir **[DOCUMENTATION.md](./DOCUMENTATION.md)**.

# Pialoa Tech — Site vitrine + back-office (Laravel 13)

Squelette de projet Laravel 13 pour le site **Pialoa Tech** : pages publiques (Accueil,
À propos, Services, Produits, Actualités/Événements) + espace admin protégé par
connexion (e-mail + mot de passe) avec CRUD sur les Produits, Services, Événements
et Stagiaires.

## 1. Ce que contient cette archive

Ce dossier contient uniquement le **code applicatif** (contrôleurs, modèles,
migrations, vues, routes, assets) — pas `vendor/`, ni le noyau Laravel lui-même,
qui doivent être générés par Composer. C'est l'approche recommandée : on part
d'une installation Laravel fraîche puis on copie ces fichiers par-dessus.

```
app/Http/Controllers/       Contrôleurs publics + Admin (CRUD)
app/Http/Middleware/        AdminMiddleware (protection /admin)
app/Models/                 User, Produit, Service, Evenement, Stagiaire
bootstrap/app.php           Enregistrement du middleware "admin"
database/migrations/        5 migrations (users, produits, services, evenements, stagiaires)
database/seeders/           Admin par défaut + données de démonstration
resources/views/            Toutes les vues Blade (public + admin) en Tailwind
resources/css/app.css       Design tokens (couleurs, boutons, cartes...)
routes/web.php              Toutes les routes
routes/console.php
public/images/logo.png      Votre logo
public/images/sample-flyer.jpeg
tailwind.config.js
vite.config.js / postcss.config.js
package.json / composer.json
.env.example
```

## 2. Installation

```bash
# 1. Créer un projet Laravel neuf (dans un autre dossier temporaire)
composer create-project laravel/laravel pialoatech-app
cd pialoatech-app

# 2. Copier le contenu de cette archive PAR-DESSUS le projet fraîchement créé
#    (écrasez composer.json, package.json, routes/web.php, bootstrap/app.php)
cp -r /chemin/vers/cette-archive/* .

# 3. Installer les dépendances PHP et JS
composer install
npm install

# 4. Configuration
cp .env.example .env
php artisan key:generate
```

Renseignez vos identifiants MySQL dans `.env` (`DB_DATABASE`, `DB_USERNAME`,
`DB_PASSWORD`), puis créez la base `pialoatech`.

```bash
# 5. Lien de stockage public (obligatoire pour afficher images/avatars/documents)
php artisan storage:link

# 6. Migrations + données de démonstration
php artisan migrate --seed

# 7. Lancer le serveur
php artisan serve
npm run dev   # dans un second terminal, pour Tailwind/Vite
```

Le site est accessible sur `http://localhost:8000`.

## 3. Connexion admin par défaut

Créée par `AdminUserSeeder` :

- **E-mail** : `admin@pialoatech.com`
- **Mot de passe** : `ChangeMoi123!`

⚠️ Changez ce mot de passe (ou modifiez le seeder) avant toute mise en production.

## 4. Charte graphique

Les couleurs sont définies comme tokens Tailwind dans `tailwind.config.js`,
reprises directement du logo Pialoa Tech :

| Token    | Hex       | Usage                          |
|----------|-----------|----------------------------------|
| `ink`    | `#14141A` | Texte principal, fonds sombres  |
| `paper`  | `#FBFAF8` | Fond clair                      |
| `ember`  | `#F2831D` | Orange — accent principal (CTA) |
| `moss`   | `#3F7D33` | Vert — accent secondaire        |
| `claret` | `#7A1F3D` | Bordeaux — alertes/accent       |
| `slate`  | `#5B5D63` | Gris — texte secondaire         |

Typographie : **Space Grotesk** (titres) + **Inter** (texte courant), chargées
via Google Fonts dans `resources/css/app.css`.

L'amas de points colorés du logo (`.dot-cluster` dans `app.css`) est repris
comme élément signature dans le header, le footer, la page de connexion et le
hero — pour ancrer visuellement chaque page à l'identité Pialoa Tech.

## 5. Fonctionnalités

**Public**
- Accueil (hero + aperçu services/produits/actualités)
- À propos
- Services (liste, chargée en BD)
- Produits (liste paginée, chargée en BD)
- Actualités / Événements (liste + page détail, avec document téléchargeable)
- Connexion admin (e-mail + mot de passe)

**Admin** (`/admin`, protégé par `auth` + middleware `admin`)
- Tableau de bord (statistiques + derniers événements)
- Produits : ajout, modification, suppression (nom, description, site web, image)
- Services : ajout, modification, suppression (nom, description, icône)
- Événements : ajout, modification, suppression (nom, description, période, image, document)
- Stagiaires : ajout, modification, suppression (nom, e-mail, période, mot de passe, secteur, avatar)

## 6. Prochaines étapes possibles

- Ajouter un espace de connexion dédié aux stagiaires (actuellement ils n'ont
  qu'une fiche gérée par l'admin)
- Gestion des rôles multiples (`role` est déjà présent sur `users`)
- Recherche/filtres sur les listes admin
- Notifications e-mail lors de l'ajout d'un événement


docker, =>Containeur


docker compose(kubernetes)=>orchestrateur 

shemas d'architechture