import{G as s}from"./google-maps-utils-Bx_Ryxi8.js";class n{constructor(){this.mapsManager=new s}async initialize(a,t){try{await this.mapsManager.initializeGoogleMaps(a,"map",()=>{this.updateMapMarkers(t)})}catch(e){console.error("Failed to initialize Google Maps:",e)}}updateMapMarkers(a){this.mapsManager.map&&(this.mapsManager.clearMarkers(),!(!a||a.length===0)&&(a.forEach(t=>{if(t.lat&&t.lng){const e={lat:t.lat,lng:t.lng},r=this.createCustomInfoWindowContent(t);this.mapsManager.addMarker(e,t.title,r)}}),this.mapsManager.fitMarkersToView(),this.mapsManager.hideMapPlaceholder()))}createCustomInfoWindowContent(a){return`
            <div class="p-4 max-w-sm">
                <div class="flex items-center space-x-3 mb-3">
                    <img src="${a.image}" alt="${a.title}" class="w-16 h-12 object-cover rounded" loading="lazy" onerror="this.style.display='none'">
                    <h3 class="font-bold text-lg text-gray-800">${a.title}</h3>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong>Cím:</strong> ${a.address}</p>
                    <p><strong>Bérleti díj:</strong> ${a.rent}</p>
                    <p><strong>Üzemeltetési díj:</strong> ${a.operating_fee}</p>
                </div>
                <div class="mt-3">
                    <a href="${a.url}" class="inline-block bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                        Részletek megtekintése
                    </a>
                </div>
            </div>
        `}refreshMarkers(a){this.mapsManager.mapInitialized&&this.updateMapMarkers(a)}}window.rentOfficesMapHandler=new n;
