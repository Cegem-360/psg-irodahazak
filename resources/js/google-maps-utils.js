/**
 * Google Maps Utilities
 * Közös funkciók a Google Maps integrációhoz
 */

export class GoogleMapsManager {
    constructor() {
        this.map = null;
        this.markers = [];
        this.geocoder = null;
        this.isGoogleMapsLoaded = false;
        this.mapInitialized = false;
        this.geocodingCache = new Map();
    }

    /**
     * Google Maps API inicializálása
     */
    async initializeGoogleMaps(
        apiKey,
        mapElementId,
        onInitCallback,
        mapId = null
    ) {
        if (!apiKey) {
            this.showMapError(
                "Google Maps API kulcs nincs konfigurálva. Kérjük, állítsa be a GOOGLE_MAPS_API_KEY környezeti változót."
            );
            return;
        }

        if (!mapId) {
            this.showMapError(
                "Google Maps Map ID nincs konfigurálva. Kérjük, állítsa be a GOOGLE_MAPS_MAP_ID környezeti változót."
            );
            return;
        }

        this.mapId = mapId;

        if (window.google && window.google.maps) {
            this.initMap(mapElementId, onInitCallback);
            return;
        }

        if (this.isGoogleMapsLoaded) {
            return;
        }

        this.isGoogleMapsLoaded = true;

        return new Promise((resolve, reject) => {
            const script = document.createElement("script");
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initGoogleMapsCallback&v=weekly&loading=async&libraries=marker`;
            script.async = true;
            script.defer = true;

            script.onerror = () => {
                this.showMapError(
                    "Google Maps betöltése sikertelen. Ellenőrizze az API kulcsot és a hálózati kapcsolatot."
                );
                reject(new Error("Google Maps loading failed"));
            };

            // Global callback for Google Maps
            window.initGoogleMapsCallback = () => {
                this.initMap(mapElementId, onInitCallback);
                resolve();
            };

            document.head.appendChild(script);
        });
    }

    /**
     * Térkép inicializálása
     */
    initMap(mapElementId, onInitCallback) {
        if (this.mapInitialized) {
            if (onInitCallback) onInitCallback();
            return;
        }

        try {
            // Check if map element exists
            const mapElement = document.getElementById(mapElementId);
            if (!mapElement) {
                console.error(
                    `Map element with ID '${mapElementId}' not found`
                );
                this.showMapError(
                    "Térkép konténer nem található. Kérjük, frissítse az oldalt."
                );
                return;
            }

            // Default center (Budapest)
            const center = { lat: 47.4979, lng: 19.0402 };
            const zoom = 11;

            // Initialize map
            this.map = new google.maps.Map(mapElement, {
                zoom: zoom,
                center: center,
                gestureHandling: "cooperative",
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: true,
                mapTypeId: "roadmap",
                mapId: this.mapId,
                // Note: styles cannot be used when mapId is present
                // Map styles are controlled via Google Cloud Console when using mapId
            });

            // Initialize geocoder
            this.geocoder = new google.maps.Geocoder();

            this.mapInitialized = true;
            this.hideMapPlaceholder();

            if (onInitCallback) onInitCallback();
        } catch (error) {
            console.error("Error initializing map:", error);
            this.showMapError("Térkép inicializálása sikertelen.");
        }
    }

    /**
     * Geocoding egy címhez
     */
    async geocodeAddress(address) {
        if (!this.geocoder) {
            throw new Error("Geocoder not initialized");
        }

        // Check cache first
        if (this.geocodingCache.has(address)) {
            return this.geocodingCache.get(address);
        }

        return new Promise((resolve, reject) => {
            this.geocoder.geocode(
                {
                    address: address + ", Hungary",
                    region: "HU",
                },
                (results, status) => {
                    if (status === "OK" && results[0]) {
                        const location = results[0].geometry.location;
                        const coords = {
                            lat: location.lat(),
                            lng: location.lng(),
                        };

                        // Cache the result
                        this.geocodingCache.set(address, coords);
                        resolve(coords);
                    } else {
                        console.warn(
                            "Geocoding failed for address:",
                            address,
                            "Status:",
                            status
                        );
                        reject(new Error(`Geocoding failed: ${status}`));
                    }
                }
            );
        });
    }

    /**
     * Markerek törlése
     */
    clearMarkers() {
        this.markers.forEach((marker) => {
            if (marker.map) {
                marker.map = null;
            }
        });
        this.markers = [];
    }

    /**
     * Marker hozzáadása
     */
    addMarker(position, title, infoContent, useAnimation = false) {
        if (!this.map) return null;

        // Create AdvancedMarkerElement
        const marker = new google.maps.marker.AdvancedMarkerElement({
            position: position,
            map: this.map,
            title: title,
        });

        // Note: AdvancedMarkerElement doesn't support DROP animation
        // Animation would need to be implemented via CSS/JS if needed

        if (infoContent) {
            const infoWindow = new google.maps.InfoWindow({
                content: infoContent,
                maxWidth: 300,
            });

            marker.addListener("click", () => {
                // Close other info windows
                this.markers.forEach((m) => {
                    if (m.infoWindow) {
                        m.infoWindow.close();
                    }
                });

                infoWindow.open(this.map, marker);
            });

            marker.infoWindow = infoWindow;
        }

        this.markers.push(marker);
        return marker;
    }

    /**
     * Térkép nézet beállítása markerek alapján
     */
    fitMarkersToView() {
        if (!this.map || this.markers.length === 0) return;

        if (this.markers.length === 1) {
            this.map.setCenter(this.markers[0].position);
            this.map.setZoom(14);
        } else {
            const bounds = new google.maps.LatLngBounds();
            this.markers.forEach((marker) => {
                bounds.extend(marker.position);
            });
            this.map.fitBounds(bounds);

            // Ensure minimum zoom level
            google.maps.event.addListenerOnce(
                this.map,
                "bounds_changed",
                () => {
                    if (this.map.getZoom() > 15) {
                        this.map.setZoom(15);
                    }
                }
            );
        }
    }

    /**
     * Info Window tartalom generálása
     */
    createInfoWindowContent(office) {
        return `
            <div class="p-3 max-w-sm">
                <h3 class="font-semibold text-lg mb-2 text-gray-900">${
                    office.title
                }</h3>
                <p class="text-sm text-gray-600 mb-2">📍 ${office.address}</p>
                ${
                    office.rent
                        ? `<p class="text-sm text-gray-600 mb-1">💰 ${office.rent}</p>`
                        : ""
                }
                ${
                    office.operating_fee
                        ? `<p class="text-sm text-gray-600 mb-3">🏢 ${office.operating_fee}</p>`
                        : ""
                }
                <a href="${office.url}" 
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Részletek megtekintése
                </a>
            </div>
        `;
    }

    /**
     * Placeholder frissítése
     */
    updateMapPlaceholder(message) {
        const placeholder = document.getElementById("map-placeholder");
        if (placeholder) {
            placeholder.style.display = "flex";
            const textElement = placeholder.querySelector("p");
            if (textElement) {
                textElement.textContent = message;
            }
        }
    }

    /**
     * Placeholder elrejtése
     */
    hideMapPlaceholder() {
        const placeholder = document.getElementById("map-placeholder");
        if (placeholder) {
            placeholder.style.display = "none";
        }
    }

    /**
     * Üzenet megjelenítése
     */
    showMapMessage(message) {
        this.updateMapPlaceholder(message);
        const placeholder = document.getElementById("map-placeholder");
        if (placeholder) {
            placeholder.style.display = "flex";
        }
    }

    /**
     * Hiba megjelenítése
     */
    showMapError(message) {
        const mapElement = document.getElementById("map");
        const errorElement = document.getElementById("map-error");
        const errorMessage = document.getElementById("map-error-message");

        if (mapElement) mapElement.style.display = "none";
        if (errorElement) {
            errorElement.classList.remove("hidden");
            errorElement.classList.add("flex");
        }
        if (errorMessage) errorMessage.textContent = message;

        console.error("Google Maps Error:", message);
    }
}
