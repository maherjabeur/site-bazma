# Site Bazma Kebili

Site Symfony avec CMS prive pour gerer l'accueil, les pages, la mediatheque, les actualites, les associations, les reseaux sociaux, le SEO et les moderateurs.

## Deploiement Production

1. Installer les dependances optimisees:

```bash
composer install --no-dev --optimize-autoloader
```

2. Configurer l'unique fichier `.env` à la racine du projet avec les valeurs de production. Aucun `.env.local`, `.env.prod` ou `.env.local.php` n'est nécessaire.

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

6. Vérifier toute la configuration sans afficher les secrets :

```bash
php bin/console app:production-check --env=prod --no-debug
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

Pour basculer temporairement vers une base MySQL locale, modifier le même fichier `.env` avec :

```text
DATABASE_URL="mysql://root:@127.0.0.1:3306/bazma?serverVersion=8.4.7&charset=utf8mb4"
APP_ENV=prod
APP_DEBUG=0
```

## Production sans Docker

Voir [DEPLOYMENT.md](DEPLOYMENT.md) pour la configuration PHP / MySQL, les variables d'environnement et les controles avant mise en ligne.

## Deploiement Render (optionnel)

Ce projet doit etre deploye sur Render avec le runtime `Docker`, pas avec un runtime natif. Le fichier `render.yaml` force Render a construire l'image depuis `Dockerfile`.

Si un service Render existe deja avec un mauvais runtime, recreer le service en choisissant `Docker` dans le champ `Language`.

Render utilise lui aussi l'unique fichier `.env` inclus dans l'image. Supprimer dans le panneau Render les anciennes variables applicatives qui portent les mêmes noms, car elles auraient priorité sur le fichier.

Pour utiliser une base PostgreSQL Render à la place de la base configurée actuellement, modifier dans `.env` :

```text
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=<long-secret-aleatoire>
DEFAULT_URI=https://ton-domaine-render-ou-ton-domaine-final
DATABASE_URL=<Internal Database URL de Render>
DB_SERVER_VERSION=18.0.0
TRANSLATION_PROVIDER=google
TRANSLATION_API_URL=https://translate.googleapis.com/translate_a/single
TRANSLATION_API_KEY=
```

Utiliser l'`Internal Database URL` si le service web et PostgreSQL sont dans le même compte Render. L'`External Database URL` fonctionne aussi, mais elle passe par l'accès public.

Le dépôt ou l'archive de déploiement doit rester privé puisque ce mode à fichier unique conserve les secrets dans `.env`.

## Administration

L'espace CMS est disponible sur `/admin`.

Les comptes sont crees en base et les permissions sont gerees depuis l'ecran `Moderateurs`.

### Traduction automatique FR / EN / AR

Dans les formulaires multilingues, il suffit de remplir une seule version d'un texte. Lors de l'enregistrement, le CMS complète uniquement les langues vides et conserve toujours les traductions saisies manuellement. Le fournisseur par défaut ne demande ni compte ni clé API et les résultats sont mis en cache pendant un an.

La traduction peut aussi utiliser une instance LibreTranslate auto-hébergée, gratuite et open source :

```text
TRANSLATION_PROVIDER=libretranslate
TRANSLATION_API_URL=http://libretranslate:5000/translate
TRANSLATION_API_KEY=
```

## Images Et Videos

Le CMS accepte JPG, PNG et WebP. Les images importees sont converties automatiquement en WebP et stockees dans `public/uploads`.

Les videos MP4, WebM et MOV peuvent etre inserees dans l'editeur. L'upload video CMS passe par morceaux pour limiter les blocages de taille cote PHP.
