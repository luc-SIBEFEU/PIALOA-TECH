> 📖 Pour l'installation détaillée, la structure du projet, le dépannage et le déploiement en production, voir **[DOCUMENTATION.md](./DOCUMENTATION.md)**.

# Pialoa Tech — Site vitrine + back-office (Laravel 13)

Squelette de projet Laravel 13 pour le site **Pialoa Tech** : pages publiques (Accueil, À propos, Services, Produits, Actualités/Événements) + espace admin protégé par connexion (e-mail + mot de passe) avec CRUD sur les Produits, Services, Événements et Stagiaires.

## 1. Installation (Méthode traditionnelle)

```bash
# 1. Installer les dépendances PHP et JS
composer install
npm install

# 2. Configuration
cp .env.example .env
php artisan key:generate
```

Renseignez vos identifiants MySQL dans `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), puis créez la base `pialoatech`.

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

## 2. Installation avec Docker (Optionnelle)

Cette méthode utilise Docker et Docker Compose pour configurer automatiquement l'environnement de développement avec PHP, MySQL et Node.js.

### Prérequis
- [Docker](https://docs.docker.com/get-docker/) installé
- [Docker Compose](https://docs.docker.com/compose/install/) installé

### Étapes d'installation

```bash
# 1. Copier le fichier d'environnement
cp .env.example .env

# 2. Générer la clé d'application
./vendor/bin/sail artisan key:generate
# Ou si vous n'avez pas encore installé les dépendances avec Composer:
# docker-compose run --rm composer create-project laravel/laravel .


# 3. Démarrer les conteneurs
docker-compose up -d

# 4. Attendre que les conteneurs soient prêts puis installer les dépendances
docker-compose exec app composer install
docker-compose exec app npm install

# 5. Exécuter les migrations et les seeders
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan storage:link

# 6. Votre application est maintenant accessible à :
#    - http://localhost:8000 (interface Laravel avec serveur de développement)
#    - Le serveur Vite pour les assets fonctionne également sur le port 5173 par défaut
```

### Configuration de l'environnement Docker

Le fichier `.env` doit contenir les configurations de base de données suivantes pour fonctionner avec Docker :
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=pialoatech
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Ces valeurs sont déjà présentes dans le fichier `.env.example` fourni.

### Arrêt et nettoyage

```bash
# Arrêter tous les conteneurs
docker-compose down

# Arrêter et supprimer les volumes (attention : cela supprimera la base de données)
docker-compose down -v
```

## 4. Installation avec Kubernetes (Recommandée pour le développement et le staging)

Cette méthode utilise un cluster Kubernetes (local avec Kind, Kubeadm, ou un service géré comme GKE/EKS/AKS) pour déployer l'application. Elle fournit une base pour passer à la production avec scalabilité haute disponibilité.

### Prérequis
- [kubectl](https://kubernetes.io/docs/tasks/tools/) installé et configuré pour pointer vers votre cluster
- [Docker](https://docs.docker.com/get-docker/) installé (pour construire les images)
- Accès à un registre d'images (ex. Docker Hub, GitHub Packages, ou un registre privé) – ici on utilise un registre local via `kind` ou `docker` pour simplicité.
- Optionnel : [kind](https://kind.sigs.k8s.io/) pour un cluster local quick-start

### Étapes d'installation (avec kind en local)

```bash
# 1. Créer un cluster local kind (si vous n'en avez pas déjà)
kind create cluster --name pialoa-dev

# 2. Construire l'image Docker de l'application et la charger dans le cluster
docker build -t pialoa/app:latest .
kind load docker-image pialoa/app:latest --name pialoa-dev

# 3. (Optionnel) Construire l'image MySQL – on utilise l'image officielle, pas besoin de builder
#    Mais si vous voulez une image custom, faites de même.

# 4. Appliquer les manifests Kubernetes
kubectl apply -f k8s/mysql-statefulset.yaml
kubectl apply -f k8s/app-deployment-service.yaml

# 5. Vérifier que les pods sont prêts
kubectl get pods -w   # attendez que le STATUS soit Running/Ready

# 6. Exécuter les migrations et les seeders (une fois que l'app est prête)
#    On lance un job temporaire ou on exec dans le pod de l'application
kubectl exec -it deploy/pialoa-app -- php artisan migrate --seed
kubectl exec -it deploy/pialoa-app -- php artisan storage:link

# 7. Exposer l'application
#    Si vous utilisez un LoadBalancer (kind ne le supporte pas vraiment, utilisez port-forward ou NodePort)
#    Pour un accès rapide avec kind :
kubectl port-forward svc/pialoa-app 8000:80  # Laravel
kubectl port-forward svc/pialoa-app 5173:5173  # Vite (optionnel, si vous avez besoin du HMR directement)

# 8. L'application est maintenant accessible :
#    - Laravel : http://localhost:8000
#    - Vite (HMR) : http://localhost:5173 (si vous avez forwardé le port)
```

### Configuration des variables d'environnement

Le ConfigMap `pialoa-app-config` (dans `k8s/app-deployment-service.yaml`) contient les variables d'environnement non sensibles.  
Le Secret `pialoa-mysql-secret` contient le mot de passe MySQL (à changer en production).  
Editez ces fichiers si vous avez besoin de valeurs différentes.

### Arrêt et nettoyage (avec kind)

```bash
# Supprimer les déploiements
kubectl delete -f k8s/app-deployment-service.yaml
kubectl delete -f k8s/mysql-statefulset.yaml

# Arrêter le cluster kind
kind delete cluster --name pialoa-dev
```

## 5. Connexion admin par défaut

Créée par `AdminUserSeeder` :

- **E-mail** : `admin@pialoatech.com`
- **Mot de passe** : `ChangeMoi123!`

⚠️ Changez ce mot de passe (ou modifiez le seeder) avant toute mise en production.

## 6. Charte graphique

Les couleurs sont définies comme tokens Tailwind dans `tailwind.config.js`, reprises directement du logo Pialoa Tech :

| Token    | Hex       | Usage                          |
|----------|-----------|----------------------------------|
| `ink`    | `#14141A` | Texte principal, fonds sombres  |
| `paper`  | `#FBFAF8` | Fond clair                      |
| `ember`  | `#F2831D` | Orange — accent principal (CTA) |
| `moss`   | `#3F7D33` | Vert — accent secondaire        |
| `claret` | `#7A1F3D` | Bordeaux — alertes/accent       |
| `slate`  | `#5B5D63` | Gris — texte secondaire         |

Typographie : **Space Grotesk** (titres) + **Inter** (texte courant), chargées via Google Fonts dans `resources/css/app.css`.

L'amas de points colorés du logo (`.dot-cluster` dans `app.css`) est repris comme élément signature dans le header, le footer, la page de connexion et le hero — pour ancrer visuellement chaque page à l'identité Pialoa Tech.

## 7. Fonctionnalités

### Public
- Accueil (hero + aperçu services/produits/actualités)
- À propos
- Services (liste, chargée en BD)
- Produits (liste paginée, chargée en BD)
- Actualités / Événements (liste + page détail, avec document téléchargeable)
- Connexion admin (e-mail + mot de passe)

### Admin (`/admin`, protégé par `auth` + middleware `admin`)
- Tableau de bord (statistiques + derniers événements)
- Produits : ajout, modification, suppression (nom, description, site web, image)
- Services : ajout, modification, suppression (nom, description, icône)
- Événements : ajout, modification, suppression (nom, description, période, image, document)
- Stagiaires : ajout, modification, suppression (nom, e-mail, période, mot de passe, secteur, avatar)

## 8. Prochaines étapes possibles

- Ajouter un espace de connexion dédié aux stagiaires (actuellement ils n'ont qu'une fiche gérée par l'admin)
- Gestion des rôles multiples (`role` est déjà présent sur `users`)
- Recherche/filtres sur les listes admin
- Notifications e-mail lors de l'ajout d'un événement

## 9. Orchestration (Docker & Kubernetes)

Les fichiers suivants décrivent l'environnement de développement :

- `Dockerfile` – image de l'application utilisée pour Docker Compose ou Kubernetes.
- `docker-compose.yml` – configuration Docker Compose (optionnelle, voir section 3).
- Répertoire `k8s/` – manifests Kubernetes :
  - `k8s/mysql-statefulset.yaml` – StatefulSet pour MySQL 8.0 avec volume persistant.
  - `k8s/app-deployment-service.yaml` – Deployment & Service pour l'application (Laravel + Vite), ConfigMap et Secret.
- `.env.example` – fichier d'exemple contenant les variables d'environnement (à copier en `.env` pour Docker ou à consulter pour Kubernetes).
- `architecture.tex` – document LaTeX détaillant l'architecture de l'environnement de développement Docker et l'utilisation de Kubernetes comme orchestrateur.

## 10. Documentation supplémentaire

Consultez  **[architecture.pdf](./architecture.pdf)**. pour une description détaillée de l'architecture (Docker Compose, Kubernetes, bonnes pratiques, monitoring, CI/CD, etc.). 
#### [Rapport de conception](rapport_conception.pdf)

