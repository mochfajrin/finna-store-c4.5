# Finna Store Setup

## First Dev Setup

```sh
npm install
composer install
npm run build
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan optimize:clear
php artisan filament:optimize
php artisan serve
```

## Refresh Migration

```sh
php artisan migration:refresh --seed
```
