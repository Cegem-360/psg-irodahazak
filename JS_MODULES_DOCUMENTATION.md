# JavaScript Modulok Strukturálása

## Áttekintés

A Google Maps funkcionalitás külön JavaScript modulokba került átszervezésre a könnyebb karbantarthatóság és újrafelhasználhatóság érdekében.

## Fájl Struktúra

```
resources/js/
├── google-maps-utils.js      # Közös Google Maps utilities
├── sale-offices-map.js       # Eladó irodák térképe (geocoding)
└── rent-offices-map.js       # Kiadó irodák térképe (koordináták)
```

## Modulok Leírása

### 1. `google-maps-utils.js`
**Szerepe**: Közös Google Maps funkcionalitás
**Funkciók**:
- `GoogleMapsManager` osztály
- API inicializálás
- Marker kezelés (hozzáadás, törlés)
- Geocoding
- InfoWindow generálás
- Hibakezelés és felhasználói visszajelzések

### 2. `sale-offices-map.js` 
**Szerepe**: Eladó irodák térképkezelése
**Speciális funkciók**:
- Geocoding API használata címekhez
- Rate limiting (200ms késleltetés)
- Cache rendszer
- Batch processing

### 3. `rent-offices-map.js`
**Szerepe**: Kiadó irodák térképkezelése  
**Speciális funkciók**:
- Koordináta-alapú marker elhelyezés
- Egyedi InfoWindow tartalom
- Azonnali megjelenítés (nincs geocoding)

## Implementáció

### Vite Konfiguráció
```javascript
// vite.config.js
input: [
    "resources/css/app.css",
    "resources/js/app.js",
    "resources/js/google-maps-utils.js",
    "resources/js/sale-offices-map.js", 
    "resources/js/rent-offices-map.js",
],
```

### Blade Template Használat
```blade
@script
<script type="module">
    import SaleOfficesMapHandler from '{{ Vite::asset('resources/js/sale-offices-map.js') }}';
    
    const apiKey = @js(config('services.google_maps.api_key'));
    let officesData = @json($this->getOfficesForMap());
    
    document.addEventListener('DOMContentLoaded', function() {
        if (window.saleOfficesMapHandler) {
            window.saleOfficesMapHandler.initialize(apiKey, officesData);
        }
    });
</script>
@endscript
```

## API Referencia

### GoogleMapsManager

#### `initializeGoogleMaps(apiKey, mapElementId, onInitCallback)`
- **apiKey**: Google Maps API kulcs
- **mapElementId**: HTML elem ID a térképhez
- **onInitCallback**: Callback funkció inicializálás után

#### `geocodeAddress(address)`
- **address**: Geocoding-olandó cím
- **Return**: Promise<{lat, lng}>

#### `addMarker(position, title, infoContent)`
- **position**: {lat, lng} koordináták
- **title**: Marker címe
- **infoContent**: InfoWindow HTML tartalma

#### `clearMarkers()`
Összes marker törlése a térképről

#### `fitMarkersToView()`
Térkép nézet beállítása az összes markerre

### Map Handlers

#### `initialize(apiKey, officesData)`
Térkép inicializálása adatokkal

#### `refreshMarkers(officesData)`
Markerek frissítése új adatokkal

## Előnyök

### 🔧 **Moduláris Felépítés**
- Külön fájlok különböző funkciókhoz
- Könnyű karbantartás és tesztelés
- Újrafelhasználható komponensek

### 🚀 **Teljesítmény**
- ES6 modulok és dinamikus import
- Vite optimalizáció
- Lazy loading lehetőség

### 📦 **Tiszta Kód**
- Osztály-alapú struktúra
- Jól definiált interfészek
- Konzisztens hibakezelés

### 🔄 **Skálázhatóság**
- Új térképtípusok könnyű hozzáadása
- Közös funkcionalitás megosztása
- Plugin rendszer lehetősége

## Használati Példák

### Új Térkép Típus Hozzáadása
```javascript
import { GoogleMapsManager } from './google-maps-utils.js';

class MyCustomMapHandler {
    constructor() {
        this.mapsManager = new GoogleMapsManager();
    }
    
    async initialize(apiKey, data) {
        await this.mapsManager.initializeGoogleMaps(apiKey, 'map', () => {
            this.updateMarkers(data);
        });
    }
    
    updateMarkers(data) {
        // Custom logic here
    }
}
```

### Közös Funkciók Kiterjesztése
```javascript
// google-maps-utils.js-ben
export class GoogleMapsManager {
    // ...existing code...
    
    addCustomMarker(position, customIcon) {
        // New functionality
    }
}
```

## Hibakeresés

### Console Üzenetek
- **Info**: Sikeres inicializálás
- **Warn**: Geocoding hibák, üres címek
- **Error**: API hibák, hitelesítési problémák

### Gyakori Problémák
1. **Module not found**: Vite build szükséges
2. **API key missing**: .env konfiguráció ellenőrzése
3. **Geocoding limit**: Rate limiting és cache használata
4. **Map not showing**: DOM element létezésének ellenőrzése

## Jövőbeli Fejlesztések

### Lehetséges Kiterjesztések
- **Clustering**: Nagy mennyiségű marker optimalizálása
- **Custom Controls**: Saját térképvezérlők
- **Offline Support**: Service Worker integráció
- **Analytics**: Térkép használat követése

## ✅ Migrációs Állapot: Befejezve

**A legújabb frissítés óta az összes térképpel kapcsolatos nézet sikeresen át lett migrálva, hogy külső ES6 modulokat használjon:**
- ✅ `list-rent-offices.blade.php` - `RentOfficesMapHandler` használatával 
- ✅ `list-sale-offices.blade.php` - `SaleOfficesMapHandler` használatával
- ✅ A régi inline JavaScript teljesen eltávolítva mindkét nézetből
- ✅ Az összes térkép logika externalizálva újrahasználható modulokba
- ✅ Vite build konfiguráció frissítve és az eszközök sikeresen felépítve
