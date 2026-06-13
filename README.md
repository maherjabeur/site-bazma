# Site Bazma Kebili

Site Symfony avec CMS prive pour gerer l'accueil, les pages, la mediatheque, les actualites, les associations, les reseaux sociaux, le SEO et les moderateurs.

## Deploiement Production

1. Installer les dependances optimisees:

```bash
composer install --no-dev --optimize-autoloader
```

2. Configurer les variables d'environnement du serveur a partir de `.env.prod.example`.

3. Preparer la base:

```bash
php bin/console doctrine:database:create --if-not-exists --env=prod
php bin/console doctrine:migrations:migrate --no-interaction --env=prod
```

4. Creer le premier administrateur:

```bash
php bin/console app:create-admin-user email@domaine.tn "MotDePasseFort" "Administrateur"
```

5. Preparer le cache:

```bash
php bin/console cache:clear --env=prod --no-debug
php bin/console cache:warmup --env=prod --no-debug
```

6. Pointer le serveur web vers le dossier `public/`.

## Deploiement Test Sur Render

Le projet contient une configuration Docker compatible Render:

- `Dockerfile`
- `docker/apache/vhost.conf`
- `docker/entrypoint.sh`
- `render.yaml`

Dans Render, creer un Blueprint depuis ce repository ou un Web Service Docker.

Variables Render a renseigner:

```text
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=valeur_generee_par_Render
DEFAULT_URI=https://votre-service.onrender.com
DATABASE_URL=mysql://USER:PASSWORD@HOST:3306/DB_NAME?serverVersion=8.4.7&charset=utf8mb4
RUN_MIGRATIONS=0
```

Mettre `RUN_MIGRATIONS=1` seulement pendant un deploiement ou vous voulez appliquer les migrations automatiquement au demarrage.

Healthcheck Render:

```text
/healthz
```

Le conteneur ecoute automatiquement le port fourni par Render via la variable `PORT`.

## Administration

L'espace CMS est disponible sur `/admin`.

Les comptes sont crees en base et les permissions sont gerees depuis l'ecran `Moderateurs`.

## Images Et Videos

Le CMS accepte JPG, PNG et WebP. Les images importees sont converties automatiquement en WebP et stockees dans `public/uploads`.

Les videos MP4, WebM et MOV peuvent etre inserees dans l'editeur. L'upload video CMS passe par morceaux pour limiter les blocages de taille cote PHP.
