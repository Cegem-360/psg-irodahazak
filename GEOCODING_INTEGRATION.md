# Geocoding-alapú Térkép Integráció

## Áttekintés

Az eladó irodák oldalon a koordináták hiánya miatt a Google Maps Geocoding API-t használjuk a címek alapján koordináták generálására.

## Működés

### Adatfolyam
1. **Backend**: `ListSaleOffices.php` → `getOfficesForMap()` → címadatok visszaadása
2. **Frontend**: JavaScript geocoding → koordináták lekérése → markerek elhelyezése

### Geocoding Folyamat
1. **Cím összeállítása**: `{irányítószám} {város}, {utca} {házszám}`
2. **Geocoding hívás**: Google Maps Geocoding API
3. **Cache**: Ismételt geocoding elkerülése
4. **Rate limiting**: 200ms késleltetés a kérések között

## Teljesítmény Optimalizálás

### Cache Rendszer
```javascript
let geocodingCache = new Map();
```
- Ugyanazt a címet nem geocoding-olja újra
- Memóriában tárolja a munkamenet alatt

### Rate Limiting
```javascript
await new Promise(resolve => setTimeout(resolve, 200));
```
- 200ms késleltetés a geocoding kérések között
- Google API kvóta túllépés elkerülése

## Hibakezelés

### Geocoding Hibák
- **Sikertelen geocoding**: Folytatás a következő címmel
- **Üres cím**: Kihagyás figyelmeztetéssel
- **API hiba**: Console warning

### Felhasználói Visszajelzés
- **Betöltés**: "Címek feldolgozása..." üzenet
- **Hiba**: "Nem sikerült megjeleníteni a címeket a térképen."
- **Üres eredmény**: Alapértelmezett térkép nézet

## API Konfiguráció

### Szükséges API Szolgáltatások
1. **Maps JavaScript API**: Térkép megjelenítés
2. **Geocoding API**: Cím → koordináta konverzió

### .env Beállítás
```
GOOGLE_MAPS_API_KEY=your_api_key_here
```

### Google Cloud Console
1. Geocoding API engedélyezése
2. API kulcs korlátozások beállítása
3. Kvóta monitoring

## Használat

### Automatikus Működés
- Oldal betöltésekor automatikus geocoding
- Lapozásnál új címek geocoding-ja
- Szűrésnél frissített címlista

### Hibakeresés
```javascript
console.warn('Geocoding failed for address:', address, 'Status:', status);
```

## Korlátozások

### Google API Kvóták
- **Ingyenes**: 40,000 geocoding kérés/hó
- **Fizetős**: $5/1000 kérés

### Sebesség
- Geocoding: ~200-500ms címenként
- 6 iroda/oldal → ~1-3 másodperc betöltés

## Alternatívák

### Koordináták Tárolása
1. **Batch geocoding**: Minden cím egyszeri feldolgozása
2. **Adatbázis mentés**: `maps_lat`, `maps_lng` mezők feltöltése
3. **Admin felület**: Koordináták manuális szerkesztése

### Performance Javítás
1. **Server-side geocoding**: Laravel job queue
2. **Cached results**: Redis/database cache
3. **Bulk processing**: Egyszerre több cím
