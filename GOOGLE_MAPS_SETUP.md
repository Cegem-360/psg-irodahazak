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

- **Több pin megjelenítése:** Az összes aktív, bérleti célú ingatlan megjelenik a térképen
- **Interaktív információs ablakok:** Kattints egy pin-re a részletek megtekintéséhez
- **Dinamikus frissítés:** A térkép automatikusan frissül a szűrők változásakor
- **Automatikus viewport:** A térkép automatikusan igazítja a nézetet az összes pin-hez
- **Hibakezelés:** Hiányzó vagy érvénytelen API kulcs esetén barátságos hibaüzenet
- **Teljesítmény optimalizálás:** Aszinkron betöltés és optimalizált marker renderelés

## Hibaelhárítás:

- **Konzol figyelmeztetések:** Lásd [Console Warnings Guide](CONSOLE_WARNINGS_GUIDE.md)
- **Advanced Marker Migration:** Lásd [Advanced Marker Migration Guide](ADVANCED_MARKER_MIGRATION.md)
- **API kulcs problémák:** Ellenőrizd a Google Cloud Console beállításokat

## Használat:

A térkép automatikusan betöltődik a "Kiadó Irodák" oldalon. A szűrők használatakor a térkép is frissül, csak a szűrési feltételeknek megfelelő ingatlanok jelennek meg.
