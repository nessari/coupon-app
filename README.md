# Coupon sharing app

Online credit card payment using Stripe

Search by geolocation with Google Maps

## Setting up the project for local development

*This project requires a Stripe account and is written in Laravel version 9.11, Inertia version 0.5. and PHP version 8.0.2. Will update soon.*

### Install dependencies

```
composer install
npm install
```

### Copy the environment example into .env file

```
cp .env.example .env
```

### Generate the applicaton key in the environment file

```
php artisan key:generate
```

### Define Stripe keys in .env file

Help to find Stripe keys: https://support.stripe.com/questions/locate-api-keys-in-the-dashboard

```
STRIPE_KEY=<your_public_key>
STRIPE_SECRET=<your_private_key>
```

### Define Google Maps key in .env file

Help to generate Google API key: https://developers.google.com/maps/get-started#api-key

```
GOOGLE_MAPS_KEY=<your_google_api_key>
```

### Run migrations and seeders

```
php artisan migrate
php artisan db:seed
```

### Compile JavaScript and start PHP server

```
npm run dev
php artisan serve
```
The HTTP server will listen to port 8000 on localhost.