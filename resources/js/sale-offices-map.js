/**
 * Sale Offices Map Handler
 * Geocoding-alapú térkép kezelés eladó irodákhoz
 */

import { GoogleMapsManager } from "./google-maps-utils.js";

class SaleOfficesMapHandler {
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
     * Térkép markerek frissítése geocoding-gal
     */
    async updateMapMarkers(offices) {
        if (!this.mapsManager.map || !this.mapsManager.geocoder) return;

        // Clear existing markers
        this.mapsManager.clearMarkers();

        if (!offices || offices.length === 0) {
            return;
        }

        // Show loading message while geocoding
        this.mapsManager.updateMapPlaceholder("Címek feldolgozása...");

        const geocodingPromises = [];
        const validOffices = [];

        // Create geocoding promises for all valid addresses
        for (let i = 0; i < offices.length; i++) {
            const office = offices[i];

            // Skip if address is empty
            if (!office.address || office.address.trim() === "") {
                console.warn("Empty address for office:", office.title);
                continue;
            }

            validOffices.push(office);

            // Add delay between requests to avoid rate limiting
            const delay = i * 300; // 300ms delay between each request

            const geocodingPromise = new Promise((resolve) => {
                setTimeout(async () => {
                    try {
                        const coords = await this.mapsManager.geocodeAddress(
                            office.address
                        );
                        resolve({ office, coords, success: true });
                    } catch (error) {
                        console.warn(
                            `Failed to geocode address "${office.address}" for office "${office.title}":`,
                            error
                        );
                        resolve({ office, coords: null, success: false });
                    }
                }, delay);
            });

            geocodingPromises.push(geocodingPromise);
        }

        // Wait for all geocoding to complete
        const geocodingResults = await Promise.all(geocodingPromises);

        // Add all successful markers at once (no animation to avoid dropping effect)
        const successfulMarkers = [];

        geocodingResults.forEach(({ office, coords, success }) => {
            if (success && coords) {
                const infoContent =
                    this.mapsManager.createInfoWindowContent(office);
                const marker = this.mapsManager.addMarker(
                    coords,
                    office.title,
                    infoContent,
                    false // No drop animation
                );

                if (marker) {
                    successfulMarkers.push(marker);
                }
            }
        });

        // Hide loading message
        this.mapsManager.hideMapPlaceholder();

        // Adjust map view if we have geocoded markers
        if (successfulMarkers.length > 0) {
            this.mapsManager.fitMarkersToView();
        } else {
            // No successful geocoding, show message
            this.mapsManager.showMapMessage(
                "Nem sikerült megjeleníteni a címeket a térképen."
            );
        }
    }

    /**
     * Markerek frissítése új adatokkal
     */
    async refreshMarkers(officesData) {
        if (this.mapsManager.mapInitialized) {
            await this.updateMapMarkers(officesData);
        }
    }
}

// Global instance
window.saleOfficesMapHandler = new SaleOfficesMapHandler();

// Export for module usage
export default SaleOfficesMapHandler;
