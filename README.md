# Alkalmazás telepítése lokális fejlesztéshez

Laravel és Vue függőségek telepítése a megfelelő composer.json és packgae.json fájlok alapján.
```
composer install
npm install
```

Enviroment fájl létrehozása és az applikáció kulcs generálása.
```
cp .env.example .env
artisan key:generate
```

Az alkalmazás helyes működéséhez a .env fájlban szükséges még megadni a Stripe privát és titkos kulcsait, illetve a Google API kulcsot.
Ahhoz, hogy ezeket meg tudjuk adni szükség van felhasználói fiókra a Stripe és a Google Maps platformokon. Ha ezek megvannak, a platformok dokumentációja alapján könnyen generálhatunk kulcsokat:
- https://support.stripe.com/questions/locate-api-keys-in-the-dashboard
- https://developers.google.com/maps/get-started

A kulcsokat a megfelelő környezeti változókba másoljuk be:
```
STRIPE_KEY=
STRIPE_SECRET_KEY=
GOOGLE_MAPS_KEY=
```

Adatbázis táblák létrehozása és feltöltése teszt adatokkal.
```
artisan migrate
artisan db:seed
```

PHP szerver indítása és JavaScript kód fordítása.
```
php artisan serve
npm run dev
```

Ha mindent jól csináltunk, akkor az alkalmazást a `127.0.0.1:8000` címen érhetjük el a böngészőből.