# GRØN KREDS

Kort over FDF-kredse der arbejder med verdensmålene, med aktiviteter og en admin til at redigere indholdet.

- Laravel 13 / PHP 8.4
- Admin: Filament 5 på `/admin` (tidligere Laravel Nova på `/nova`, som nu viderestiller)
- Frontend: Vite + Vue 3 + Bootstrap 5. De byggede filer i `public/build` er committet, så produktion ikke skal bygge.

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

Sæt `VITE_GOOGLE_MAPS_KEY` i `.env` (bruges af kortet).

Siden kører på http://localhost og admin på http://localhost/admin.

## Frontend

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev     # udvikling med hot reload
./vendor/bin/sail npm run build   # byg til produktion, og commit public/build
```

Tests: `./vendor/bin/sail artisan test`
