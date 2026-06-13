# Site Bazma Kebili

Site Symfony avec CMS privé pour gérer l’accueil, les pages, la médiathèque, les actualités, les associations, les réseaux sociaux, le SEO et les modérateurs.

## Déploiement Production

1. Installer les dépendances optimisées:

```bash
composer install --no-dev --optimize-autoloader
```

2. Configurer les variables d’environnement du serveur à partir de `.env.prod.example`.

3. Préparer la base:

```bash
php bin/console doctrine:database:create --if-not-exists --env=prod
php bin/console doctrine:migrations:migrate --no-interaction --env=prod
```

4. Créer le premier administrateur:

```bash
php bin/console app:create-admin-user email@domaine.tn "MotDePasseFort" "Administrateur"
```

5. Préparer le cache:

```bash
php bin/console cache:clear --env=prod --no-debug
php bin/console cache:warmup --env=prod --no-debug
```

6. Pointer le serveur web vers le dossier `public/`.

## Administration

L’espace CMS est disponible sur `/admin`.

Les comptes sont créés en base et les permissions sont gérées depuis l’écran `Modérateurs`.

## Images

Le CMS accepte JPG, PNG et WebP. Les images importées sont converties automatiquement en WebP et stockées dans `public/uploads`.
