# Filament Starter Kit

Filament Starter Kit is a distribution of [Filament](https://filamentphp.com/) with a variety of pre-installed components. Simple things are the best for your starting point.

## New Installation

To install Filament Starter Kit, run:

```bash
composer create-project dcrepper/filament-starter-kit
```

After installation, run the migrations:

```bash
php artisan migrate
```

Create the first (admin) user:

```bash
php artisan make:filament-user
```

Then seed the database:

```bash
php artisan db:seed
```

Visit `/admin` on your site to see the Filament login screen.  
Log in with the user created in step #4.

All relevant migrations, views, and config files have been published to the main Laravel directory tree in the expected locations.  
If a package (such as a Spatie package) is based on another package, the base package migrations and config files are also published.

# Production Section

For production, ensure you implement `FilamentUser` in your User model and add the `canAccessPanel` function.  
See the [Filament documentation](https://filamentphp.com/docs/3.x/panels/installation#deploying-to-production) for details.

# Modulok

## Referencia Modul

A referencia modul lehetővé teszi ügyfél logók/referenciák kezelését.

### Funkciók:
- Név és kép tárolása
- Sorrend meghatározása (0 = első, 1 = második, stb.)
- Aktív/inaktív állapot
- Filament admin felület magyar nyelvű címkékkel
- Képek tárolása `storage/app/public/references` mappában
- Drag & drop átrendezés a Filament admin felületen

### Használat:

#### Admin felületen:
Látogasd meg a `/admin/references` oldalt a referenciák kezeléséhez.

#### Frontend használat:
```php
// Helper függvény használata
$references = get_references();

// Vagy közvetlenül a modellen keresztül
$references = \App\Models\Reference::active()->ordered()->get();
```

#### Livewire komponens:
```blade
<livewire:reference-list />
```

### API Végpontok:
A referenciák lekérdezhetők REST API-n keresztül is (ha szükséges).

## License

The MIT License. Please see [the license file](LICENSE.md) for more information.