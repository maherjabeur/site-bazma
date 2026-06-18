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

## Demo Locale Avec MySQL

Pre-requis: PHP, Composer, MySQL 8 local et le client `mysql` accessibles dans le terminal.

1. Installer les dependances si necessaire:

```bash
composer install
```

2. Preparer la base locale `bazma` depuis le dump inclus:

```powershell
.\scripts\local-demo-mysql.ps1
```

Si Windows bloque l'execution des scripts PowerShell:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\local-demo-mysql.ps1
```

Si MySQL utilise un mot de passe:

```powershell
.\scripts\local-demo-mysql.ps1 -DbUser root -DbPassword "mot_de_passe"
```

Avec WAMP, si `mysql` n'est pas dans le `PATH`:

```powershell
.\scripts\local-demo-mysql.ps1 -Mysql "C:\wamp64\bin\mysql\mysql8.4.7\bin\mysql.exe"
```

3. Lancer le serveur PHP integre:

```bash
php -S localhost:8000 -t public
```

Sur certaines installations Windows/WAMP, si `http://localhost:8000` coupe la connexion, lancer ou ouvrir avec l'adresse IPv4:

```bash
php -S 127.0.0.1:8000 -t public
```

Le site sera disponible sur:

```text
http://localhost:8000
http://127.0.0.1:8000
```

La configuration locale par defaut utilise:

```text
DATABASE_URL="mysql://root:@127.0.0.1:3306/bazma?serverVersion=8.4.7&charset=utf8mb4"
APP_ENV=prod
APP_DEBUG=0
```

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
