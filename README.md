# GRØN KREDS

Kort over FDF-kredse der arbejder med verdensmålene, med aktiviteter og en admin til at redigere indholdet.

- Laravel 13 / PHP 8.4
- Admin: Filament 5 på `/admin` (tidligere Laravel Nova på `/nova`, som nu viderestiller)
- Frontend: Laravel Mix 4 + Vue 2 + Bootstrap 4 (de byggede filer i `public/js` og `public/css` er committet)

## Lokal udvikling med Sail

Kræver Docker.

```bash
cp .env.example .env

# Første gang: installér PHP-pakker uden at have PHP lokalt
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html \
    laravelsail/php84-composer:latest composer install --ignore-platform-req=ext-intl

./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
```

Siden kører på http://localhost og admin på http://localhost/admin.

Tests: `./vendor/bin/sail artisan test`
