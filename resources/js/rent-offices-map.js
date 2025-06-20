/**
 * Rent Offices Map Handler
 * Koordináta-alapú térkép kezelés kiadó irodákhoz
 */

import { GoogleMapsManager } from "./google-maps-utils.js";

class RentOfficesMapHandler {
    constructor() {
        this.mapsManager = new GoogleMapsManager();
    }

    /**
     * Inicializálás
     */
    async initialize(apiKey, officesData) {
        try {
            await this.mapsManager.initializeGoogleMaps(apiKey, "map", () => {
                this.updateMapMarkers(officesData);
            });
        } catch (error) {
            console.error("Failed to initialize Google Maps:", error);
        }
    }

    /**
     * Térkép markerek frissítése koordináták alapján
     */
    updateMapMarkers(offices) {
        if (!this.mapsManager.map) return;

        // Clear existing markers
        this.mapsManager.clearMarkers();

        if (!offices || offices.length === 0) {
            return;
        }

        // Add markers for offices with coordinates
        offices.forEach((office) => {
            if (office.lat && office.lng) {
                const position = { lat: office.lat, lng: office.lng };
                const infoContent = this.createCustomInfoWindowContent(office);
                this.mapsManager.addMarker(position, office.title, infoContent);
            }
        });

        // Adjust map view to fit all markers
        this.mapsManager.fitMarkersToView();
        this.mapsManager.hideMapPlaceholder();
    }

    /**
     * Kiadó irodákhoz speciális InfoWindow tartalom
     */
    createCustomInfoWindowContent(office) {
        return `
            <div class="p-4 max-w-sm">
                <div class="flex items-center space-x-3 mb-3">
                    <img src="${office.image}" alt="${office.title}" class="w-16 h-12 object-cover rounded" loading="lazy" onerror="this.style.display='none'">
                    <h3 class="font-bold text-lg text-gray-800">${office.title}</h3>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Cím:</strong> ${office.address}</p>
                    <p><strong>Bérleti díj:</strong> ${office.rent}</p>
                    <p><strong>Üzemeltetési díj:</strong> ${office.operating_fee}</p>
                </div>
                <div class="mt-3">
                    <a href="${office.url}" class="inline-block bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                        Részletek megtekintése
                    </a>
                </div>
            </div>
        `;
    }

    /**
     * Markerek frissítése új adatokkal
     */
    refreshMarkers(officesData) {
        if (this.mapsManager.mapInitialized) {
            this.updateMapMarkers(officesData);
        }
    }
}

// Global instance
window.rentOfficesMapHandler = new RentOfficesMapHandler();

// Export for module usage
export default RentOfficesMapHandler;
