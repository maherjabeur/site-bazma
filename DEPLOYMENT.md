# Production PHP / MySQL

Le site fonctionne sur un hebergement PHP classique, sans Docker et sans compilation Node.js.

## Configuration

1. Utiliser PHP 8.2 ou plus, avec les extensions demandees par Composer, dont PDO MySQL et GD.
2. Configurer la racine web sur `public/`, jamais sur la racine du projet.
3. Utiliser uniquement le fichier `.env` à la racine du projet. Ne pas créer `.env.local`, `.env.prod` ou `.env.local.php`. Les transferts FTP peuvent ignorer les fichiers dont le nom commence par un point : vérifier explicitement que `.env` est présent sur le serveur et reste hors du dossier public.
4. Renseigner dans ce fichier unique `APP_ENV=prod`, `APP_DEBUG=0`, un `APP_SECRET` aléatoire, `DEFAULT_URI` avec le domaine HTTPS, `DATABASE_URL`, `DB_SERVER_VERSION`, `TRANSLATION_PROVIDER`, `TRANSLATION_API_URL` et `TRANSLATION_API_KEY`. Encoder les caractères spéciaux du nom et du mot de passe dans l'URL de base de données.
5. Autoriser le processus PHP a ecrire dans `var/` et `public/uploads/`. Conserver les photos et videos existantes lors des mises a jour.

Une variable définie par le panneau de l'hébergeur peut prendre priorité sur `.env`. Pour fonctionner strictement avec ce seul fichier, supprimer du panneau les anciennes variables portant les mêmes noms. Ne pas publier la sortie de `debug:dotenv`, qui peut afficher les identifiants.

Supprimer tout ancien `.env.local.php` : ce cache empêcherait certaines modifications du fichier `.env` d'être prises en compte.

## Mise a jour

Sauvegarder la base avant les migrations. Depuis la racine du projet sur le serveur :

```bash
composer install --no-dev --optimize-autoloader --no-interaction
php bin/console app:production-check --env=prod --no-debug
php bin/console doctrine:query:sql "SELECT 1" --env=prod --no-debug
php bin/console doctrine:migrations:migrate --no-interaction --env=prod --no-debug
php bin/console lint:twig templates --env=prod --no-debug
php bin/console lint:yaml translations config --env=prod --no-debug
php bin/console cache:clear --env=prod --no-debug
php bin/console cache:warmup --env=prod --no-debug
```

Arreter au premier echec. Sous Windows, `scripts/prod-build.ps1` execute cette preparation et arrete le processus si une commande echoue.

Ne pas lancer `app:seed-content` ni `scripts/local-demo-mysql.ps1` sur la production : ces outils remplacent les donnees existantes.

## Verification

Vérifier `/fr`, `/ar`, `/en`, la galerie, une actualité et `/login`, puis les menus sur téléphone. `/healthz` confirme que PHP et Symfony répondent. La commande `app:production-check` contrôle aussi la connexion à la base, les variables obligatoires et les dossiers accessibles en écriture sans afficher les secrets.

La refonte conserve les contenus du CMS. Les nouveaux textes d'interface sont dans `translations/messages.*.yaml`. Les styles publics sont dans `public/assets/village.css` et les interactions dans `public/assets/village.js`.

L'apercu local de validation utilise une base SQLite isolee dans `var/`, avec du contenu de demonstration. Cette base ne doit pas etre transferee en production.
