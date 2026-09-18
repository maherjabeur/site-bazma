# Production PHP / MySQL

Le site fonctionne sur un hebergement PHP classique, sans Docker et sans compilation Node.js.

## Configuration

1. Utiliser PHP 8.2 ou plus, avec les extensions demandees par Composer, dont PDO MySQL et GD.
2. Configurer la racine web sur `public/`, jamais sur la racine du projet.
3. Conserver un fichier `.env` a la racine du projet (les transferts FTP peuvent ignorer les fichiers caches). Mettre les valeurs propres au serveur dans `.env.local`, hors de `public/`, en prenant `.env.prod.example` comme modele.
4. Renseigner `APP_ENV=prod`, `APP_DEBUG=0`, un `APP_SECRET` aleatoire, `DEFAULT_URI` avec le domaine HTTPS et `DATABASE_URL` avec les identifiants de la base fournis par l'hebergeur. Encoder les caracteres speciaux du nom et du mot de passe dans l'URL. Adapter `DB_SERVER_VERSION` a la version MySQL ou MariaDB effective.
5. Autoriser le processus PHP a ecrire dans `var/` et `public/uploads/`. Conserver les photos et videos existantes lors des mises a jour.

Une variable definie par le panneau de l'hebergeur peut prendre priorite sur les fichiers `.env`. En cas de connexion `root@localhost` sans mot de passe, verifier cette variable et le fichier transfere. Ne pas publier la sortie de `debug:dotenv`, qui peut afficher les identifiants.

Si un ancien `.env.local.php` existe, regenerer ce cache d'environnement avec `composer dump-env prod` apres toute modification des valeurs.

## Mise a jour

Sauvegarder la base avant les migrations. Depuis la racine du projet sur le serveur :

```bash
APP_ENV=prod APP_DEBUG=0 composer install --no-dev --optimize-autoloader --no-interaction
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

Verifier `/fr`, `/ar`, `/en`, la galerie, une actualite et `/login`, puis les menus sur telephone. `/healthz` confirme que PHP et Symfony repondent ; il ne teste pas la base. Les contenus publics necessitent une connexion MySQL operationnelle.

La refonte conserve les contenus du CMS. Les nouveaux textes d'interface sont dans `translations/messages.*.yaml`. Les styles publics sont dans `public/assets/village.css` et les interactions dans `public/assets/village.js`.

L'apercu local de validation utilise une base SQLite isolee dans `var/`, avec du contenu de demonstration. Cette base ne doit pas etre transferee en production.
