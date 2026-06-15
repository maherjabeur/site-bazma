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

## Docker Avec MySQL

```bash
docker compose up --build
```

Le site sera disponible sur:

```text
http://localhost:8000
```

La base MySQL locale ecoute sur le port `3307` de la machine hote.

Le conteneur web construit automatiquement une URL MySQL locale a partir de `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` et `DB_SERVER_VERSION`.

## Deploiement Render

Ce projet doit etre deploye sur Render avec le runtime `Docker`, pas avec un runtime natif. Le fichier `render.yaml` force Render a construire l'image depuis `Dockerfile`.

Si un service Render existe deja avec un mauvais runtime, recreer le service en choisissant `Docker` dans le champ `Language`.

Pour une base PostgreSQL Render, renseigner:

```text
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=<long-secret-aleatoire>
DEFAULT_URI=https://ton-domaine-render-ou-ton-domaine-final
DATABASE_URL=<Internal Database URL de Render>
DB_SERVER_VERSION=18.0.0
RUN_MIGRATIONS=1
```

Utiliser l'`Internal Database URL` si le service web est aussi sur Render. L'`External Database URL` fonctionne aussi, mais elle passe par l'acces public.

Si Render affiche `Invalid platform version "" specified`, verifier dans `Environment` que `DB_SERVER_VERSION` n'est pas vide. Pour PostgreSQL 18, la valeur recommandee est `18.0.0`. Si `DATABASE_URL` contient un parametre `serverVersion`, il doit etre `serverVersion=18.0.0`, jamais `serverVersion=`.

## Administration

L'espace CMS est disponible sur `/admin`.

Les comptes sont crees en base et les permissions sont gerees depuis l'ecran `Moderateurs`.

## Images Et Videos

Le CMS accepte JPG, PNG et WebP. Les images importees sont converties automatiquement en WebP et stockees dans `public/uploads`.

Les videos MP4, WebM et MOV peuvent etre inserees dans l'editeur. L'upload video CMS passe par morceaux pour limiter les blocages de taille cote PHP.
