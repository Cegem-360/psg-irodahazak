# Google Maps Integráció Beállítása

## Szükséges lépések:

1. **Google Maps API kulcs megszerzése:**
   - Látogasd meg a [Google Cloud Console](https://console.cloud.google.com/) oldalt
   - Hozz létre egy új projektet vagy válassz ki egy meglévőt
   - Engedélyezd a "Maps JavaScript API"-t
   - Hozz létre egy API kulcsot
   - Korlátozd az API kulcs használatát biztonság érdekében

2. **Környezeti változó beállítása:**
   ```bash
   # Másold le a .env.google-maps.example fájl tartalmát a .env fájlodba
   GOOGLE_MAPS_API_KEY=your_actual_api_key_here
   ```

3. **Ingatlan koordináták hozzáadása:**
   - Az adminisztrációs felületen vagy közvetlenül az adatbázisban add meg az ingatlanok `maps_lat` és `maps_lng` koordinátáit
   - Csak azok az ingatlanok jelennek meg a térképen, amelyeknek van koordinátájuk

## Funkciók:

- **Több pin megjelenítése:** Az összes aktív, bérleti/eladási célú ingatlan megjelenik a térképen
- **Interaktív információs ablakok:** Kattints egy pin-re a részletek megtekintéséhez
- **Dinamikus frissítés:** A térkép automatikusan frissül a szűrők és lapozás változásakor
- **Automatikus viewport:** A térkép automatikusan igazítja a nézetet az összes pin-hez
- **Hibakezelés:** Hiányzó vagy érvénytelen API kulcs esetén barátságos hibaüzenet
- **Teljesítmény optimalizálás:** Aszinkron betöltés és optimalizált marker renderelés
- **Moduláris architektúra:** JavaScript kód külön fájlokban, ES6 modulok használatával
- **Geocoding támogatás:** Eladási ingatlanok esetén automatikus címgeokódolás

## Technikai részletek:

### Livewire integráció:
- **Livewire 3.x kompatibilis:** Modern hooks és $wire API használata
- **Végtelen ciklus védelem:** Intelligens állapotkezelés a hook-okban
- **Hibatűrő adatfrissítés:** Automatikus fallback mechanizmusok

### JavaScript modulok:
- `resources/js/google-maps-utils.js` - Közös térkép funkciók
- `resources/js/rent-offices-map.js` - Bérleti irodák kezelése
- `resources/js/sale-offices-map.js` - Eladási irodák kezelése (geocoding)

## Hibaelhárítás:

- **Konzol figyelmeztetések:** Lásd [Console Warnings Guide](CONSOLE_WARNINGS_GUIDE.md)
- **Advanced Marker Migration:** Lásd [Advanced Marker Migration Guide](ADVANCED_MARKER_MIGRATION.md)
- **Livewire Hooks:** Lásd [Livewire Hooks Best Practices](LIVEWIRE_HOOKS_BEST_PRACTICES.md)
- **API kulcs problémák:** Ellenőrizd a Google Cloud Console beállításokat
- **Geocoding integration:** Lásd [Geocoding Integration Guide](GEOCODING_INTEGRATION.md)

## Használat:

A térkép automatikusan betöltődik a "Kiadó Irodák" és "Eladó Irodák" oldalakon. A szűrők és lapozás használatakor a térkép is frissül, csak az aktuálisan látható ingatlanok jelennek meg.

### Kiadó irodák:
- Koordináták alapján működik (`maps_lat`, `maps_lng`)
- Gyors, közvetlen marker megjelenítés

### Eladó irodák:
- Címgeokódolás alapján működik
- Automatikus koordináta generálás a címből
- Rate limiting és hibakezelés
