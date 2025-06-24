# Ingatlan PDF Generáló Funkció + Impresszum Kezelő

## Legfrissebb Frissítések

### 2024-01-XX - Impresszum Kezelő Funkció

**Új admin funkció az impresszum kezeléséhez**:
- **Filament admin oldal**: `/admin/impresszum-page`
- **Adatbázis tábla**: `impressum` (id, title, content, is_active, timestamps)
- **Rich Editor**: Teljes körű szövegszerkesztő a tartalom kezeléséhez
- **Frontend megjelenítés**: `/impresszum` route-on elérhető

**Funkciók**:
- ✅ Rich Editor (bold, italic, linkek, listák, címsorok, stb.)
- ✅ Cím és aktív státusz kezelése
- ✅ Automatikus mentés
- ✅ Frontend megjelenítés
- ✅ Responsive design

**Használat**:
1. Admin → Impresszum menüpont
2. Tartalom szerkesztése a Rich Editor-rel
3. Mentés gombbal elmentés
4. `/impresszum` oldalon megjelenik a tartalma

**Technikai részletek**:
- Model: `App\Models\Impresszum`
- Page: `App\Filament\Pages\ImpresszumPage`
- Controller: `App\Http\Controllers\ImpresszumController`
- View: `resources/views/impresszum.blade.php`

### 2024-01-XX - Browsershot Footer Implementáció

**Professzionális Footer Kezelés**:
- Browsershot natív `footerHtml()` funkciójának használata
- Külön footer template (`resources/views/pdf/footer.blade.php`) létrehozása
- Alsó margó növelése a footer számára (25mm)
- **Előnyök**:
  - Minden PDF oldalon automatikusan megjelenik
  - Konzisztens formázás és pozicionálás
  - Könnyű módosíthatóság
  - Nem befolyásolja a fő tartalom elrendezését

**Footer tartalom**:
```
KONTAKT: Fekete Richard, T.: +36 20 381 3917
mail: richard.fekete@psg-irodahazak.hu
```

### 2024-01-XX - Storage Facade és @use Direktíva

**Storage API Optimalizálás**:
- `@use('Illuminate\Support\Facades\Storage')` direktíva hozzáadva a Blade template tetejére
- Fejlettebb képkeresési logika implementálva:
  1. `Storage::files()` használata az elérhető fájlok dinamikus feltérképezéséhez
  2. Intelligens fájlszűrés base name alapján
  3. Duplán biztonságos fallback mechanizmus
- **Előnyök**:
  - Nincs szükség előre definiált méretlistára
  - Automatikusan megtalálja az összes elérhető képméretet
  - Tisztább, maintainableabb kód
  - Laravel best practices követése

### 2024-01-XX - Kép Elérési Út Javítás

**Probléma**: A `getFirstImageUrl` metódus nem mindig létező képet adott vissza, ami "kép nem elérhető" hibaüzenetet eredményezett.

**Megoldás**:
- A PDF template mostantól közvetlenül ellenőrzi a fájlok létezését a `file_exists()` függvénnyel
- A kép kiválasztási logika:
  1. Különböző méreteket próbál meg (1920x1080, 1600x1200, 1200x900, 1024x768, 800x600, 640x480)
  2. Az első létező fájlt választja ki
  3. Ha egyik méret sem létezik, az eredeti kép elérési útját használja
  4. Csak akkor jeleníti meg a képet, ha ténylegesen létezik

**Főbb változások**:
- **Fő kép**: Intelligens méret-felismerés és létezés-ellenőrzés
- **Galéria képek**: Különböző méretek kipróbálása (640x480, 480x360, 320x240)
- **ÁFA kiemelés**: Csak akkor jelenik meg, ha az érték pontosan "igen", sárga háttér helyett piros szín
- **Hibakezelés**: Csak létező képek megjelenítése, "Kép nem elérhető" placeholder a hiányzó képekhez

---

## Áttekintés

Ez a funkció lehetővé teszi az ingatlan adatok PDF formátumban történő exportálását a Filament admin felületén.

## Telepítés és Beállítás

### Előfeltételek

1. **Node.js** és **npm** telepítése
2. **Puppeteer** telepítése: `npm install puppeteer`
3. **spatie/browsershot** csomag (már telepítve)

### Konfigurálás

A PDF generálás konfigurációja a `config/pdf.php` fájlban található:

```php
return [
    'browsershot' => [
        'format' => 'A4',
        'margins' => [
            'top' => 15,
            'right' => 15,
            'bottom' => 15,
            'left' => 15,
        ],
        'timeout' => 60,
        'show_background' => true,
        'wait_until_network_idle' => true,
    ],
    'property' => [
        'max_images' => 6,
        'default_image_height' => 200,
    ],
];
```

## Funkciók

### 1. PDF Generálás Filament-ban

A PDF generálás elérhető:

- **Szerkesztés oldal**: Header action gombként - új ablakban nyílik meg
- **Megtekintés oldal**: Header action gombként - új ablakban nyílik meg
- **Lista oldal**: Minden ingatlan sorában action gombként - új ablakban nyílik meg

**Fontos**: A PDF-ek már nem letöltődnek automatikusan, hanem új böngésző ablakban nyílnak meg, ahol a felhasználó eldöntheti, hogy menti vagy nyomtatja.

### 2. Használt Fájlok

#### Backend Fájlok:
- `app/Services/PropertyPdfService.php` - PDF generálási logika (download és view metódusok)
- `app/Filament/Resources/PropertyResource.php` - Frissítve action gombokkal
- `app/Filament/Resources/PropertyResource/Pages/EditProperty.php` - PDF action (új ablak)
- `app/Filament/Resources/PropertyResource/Pages/ViewProperty.php` - PDF action (új ablak)
- `config/pdf.php` - Konfigurációs fájl
- `routes/web.php` - PDF megjelenítő route

#### Frontend Fájlok:
- `resources/views/pdf/property.blade.php` - PDF template Tailwind CSS-szel
- `resources/views/pdf/property-old.blade.php` - Biztonsági másolat (régi CSS)
- `resources/views/pdf/property-new.blade.php` - Fejlesztési verzió

### 3. PDF Tartalom

A generált PDF tartalmazza:

- **Professzionális header**: PSG logóval, kék gradiens háttérrel
- **Címlapkép**: Nagy méretű főkép bal oldalon
- **Ingatlan adatok**: Jobb oldali strukturált lista formában
  - Építési év, összterület, kiadó területek
  - Bérleti díjak (EUR/m2/hó)
  - Üzemeltetési díjak (HUF/m2/hó)
  - Raktár információk
  - Parkolási lehetőségek és díjak
  - Közös területi arány
  - Minimális bérleti időszak
  - Kódszám
  - ÁFA információ (kiemelve)
- **Galériakép**: Alsó részben 3x2 elrendezésben további képek
- **Leírások**: Rövid és részletes leírás (ha van)
- **Professzionális lábjegyzet**: Generálási időpont

### 4. Tesztelés

#### Filament Admin Felületén
1. Navigálj az "Ingatlanok" menüpontra
2. Válassz egy ingatlant (lista vagy részletes nézet)
3. Kattints a "PDF Generálás" vagy "PDF" gombra
4. Erősítsd meg a generálást a modal ablakban
5. A PDF új böngésző ablakban nyílik meg

#### Közvetlen URL-en keresztül
- Megjelenítés: `/property-pdf/{ingatlan_id}`
- Tesztelés: `/test-pdf/{ingatlan_id}` (távolítsd el éles környezetben!)

**Fontos**: Éles környezetben távolítsd el a teszt route-ot!

## Használat

### Filament Admin Felületén

1. Navigálj az "Ingatlanok" menüpontra
2. Válassz egy ingatlant
3. Kattints a "PDF Generálás" gombra
4. Erősítsd meg a generálást a modal ablakban
5. A PDF automatikusan megnyílik új böngésző ablakban

### Programozottan

```php
use App\Services\PropertyPdfService;
use App\Models\Property;

$property = Property::find(1);
$pdfService = new PropertyPdfService();

// PDF letöltés (régi metódus)
return $pdfService->generatePdf($property);

// PDF megjelenítés böngészőben (új metódus)
return $pdfService->generatePdfForView($property);

// PDF mentés
$path = $pdfService->savePdf($property, 'custom/path/filename.pdf');
```

## Hibaelhárítás

### Gyakori problémák:

1. **Puppeteer nem található**
   ```bash
   npm install puppeteer
   ```

2. **Képek nem jelennek meg**
   - Ellenőrizd a storage linkeket: `php artisan storage:link`
   - Ellenőrizd a fájl útvonalakat

3. **Timeout hiba**
   - Növeld a timeout értéket a konfigurációban
   - Ellenőrizd a szerver erőforrásokat

4. **Memória hiba**
   - Növeld a PHP memória limitet
   - Csökkentsd a képek számát

## Testreszabás

### PDF Stílus Módosítása

A PDF megjelenését a `resources/views/pdf/property.blade.php` fájlban módosíthatod.

### Konfigurációk Módosítása

A `config/pdf.php` fájlban állíthatod be a PDF generálás paramétereit.

### Új Mezők Hozzáadása

1. Módosítsd a `resources/views/pdf/property.blade.php` template-et
2. Add hozzá az új mezők megjelenítését
3. Frissítsd a CSS stílusokat szükség szerint

## Biztonsági Megjegyzések

- A PDF generálás csak autentikált felhasználóknak érhető el
- A teszt route-ot távolítsd el éles környezetben
- Ellenőrizd a fájl hozzáférési jogosultságokat
- Figyelj a szerver erőforrások használatára

## Teljesítmény Optimalizálás

- Használj képtömörítést
- Állítsd be a megfelelő timeout értékeket
- Figyelj a memóriahasználatra
- Használj queue-t nagyobb PDF-ekhez

## Új Professzionális Design

A PDF design mostantól követi a PSG Professional layout-ot:

- **Kék gradiens header** PSG logóval
- **Két oszlopos elrendezés**: bal oldalt főkép, jobb oldalt adatok
- **Strukturált adatmegjelenítés**: címke-érték párok
- **Kiemelések**: ÁFA információ sárga háttérrel
- **Galériakép rács**: 3x2 elrendezésben
- **Professzionális tipográfia**: Arial font, megfelelő méretek
- **Tailwind CSS**: Modern utility-first CSS framework
- **Responsive design**: Optimalizált elrendezés

A design teljesen megegyezik a mellékelt mintával és modern Tailwind CSS osztályokat használ.

### Tailwind CSS Integráció

A PDF-ek most Tailwind CSS-t használnak:

- **CDN betöltés**: Tailwind CSS CDN-ből
- **Egyedi színek**: PSG brand színek konfigurálva
- **Utility classes**: Modern Tailwind osztályok
- **Delay mechanizmus**: 2 másodperc várakozás a CSS betöltésére
- **Optimalizált timeout**: 90 másodperc timeout érték

#### Használt Tailwind Osztályok:
- Layout: `flex`, `w-1/2`, `grid`, `grid-cols-3`
- Spacing: `p-8`, `py-2`, `mt-8`, `gap-4`
- Colors: `bg-gray-50`, `text-gray-600`, `bg-yellow-100`
- Typography: `font-bold`, `text-sm`, `leading-relaxed`
- Effects: `rounded`, `border-b`, `shadow`
