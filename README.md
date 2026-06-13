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

Le conteneur web construit automatiquement `DATABASE_URL` a partir de `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` et `DB_PASSWORD`.

## Deploiement Render

Ce projet doit etre deploye sur Render avec le runtime `Docker`, pas avec un runtime natif. Le fichier `render.yaml` force Render a construire l'image depuis `Dockerfile`.

Si un service Render existe deja avec un mauvais runtime, recreer le service en choisissant `Docker` dans le champ `Language`, puis renseigner les variables `DEFAULT_URI`, `DB_HOST`, `DB_NAME`, `DB_USER` et `DB_PASSWORD`.

Si Render affiche `Invalid platform version "" specified`, verifier dans `Environment` que `PHP_VERSION` et `COMPOSER_PLATFORM_PHP` ne sont pas vides. Les deux doivent valoir `8.3.0`.

## Administration

L'espace CMS est disponible sur `/admin`.

Les comptes sont crees en base et les permissions sont gerees depuis l'ecran `Moderateurs`.

## Images Et Videos

Le CMS accepte JPG, PNG et WebP. Les images importees sont converties automatiquement en WebP et stockees dans `public/uploads`.

Les videos MP4, WebM et MOV peuvent etre inserees dans l'editeur. L'upload video CMS passe par morceaux pour limiter les blocages de taille cote PHP.
