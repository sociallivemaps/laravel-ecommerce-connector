# Solimap Ecommerce Package

This package integrates Solimap Ecommerce into any Laravel project.

## Installation

```bash
composer require sociallivemaps/laravel-ecommerce-connector
```

2. Add the following to your `.env` file:

```env
SOLIMAP_BASE_URL=https://pay2go.solimap.com/api/v1
SOLIMAP_CLIENT_ID=<your-client-id>
SOLIMAP_EVENT_ID=<your-event-id>
SOLIMAP_APP_PREFIX=ecommerce
```

---

## Usage

After installation and configuration, you can access Solimap products at:

```
https://your-domain.com/ecommerce/bundles
```

---

## Notes

- If no prefix is set in config, the default prefix will be `solimap`.
- Make sure to clear your config cache after updating `.env`:

```bash
php artisan config:clear
php artisan cache:clear
```

## Get images

```bash
php artisan vendor:publish --tag=solimap-config
php artisan vendor:publish --tag=solimap-views
php artisan vendor:publish --tag=solimap-assets
```

## Php optimize

```bash
php artisan optimize
```
