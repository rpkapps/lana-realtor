import utils from '../utils.js';
import listingMapTooltip from '../templates/listing-map-tooltip.js'

var mapCenter = [65.339248, -150.885501];

window.map = null;
window.markers = L.markerClusterGroup();

function init() {
    if(!map) {
        map = L.map('mapView', {
            maxBounds: [
                [72, -173],
                [52, -139]
            ],
            maxZoom: 18,
            minZoom: 5
        }).setView(mapCenter, 3);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoicnBrb2xlc25payIsImEiOiJjams1bnlyaGowdmdhM3BuY3B6dTY1em1yIn0.lJw7tKQ_2H0M1K-PiMtXNQ'
        }).addTo(map);

        map.addLayer(markers);
    }
}

/**
 * Refresh map
 */
function refresh() {
    // Refresh map needed for when map is lo
    map._onResize();
}

/**
 * Add listings to map
 */
function updateListings(listings = []) {
    markers.clearLayers();

    listings.forEach(function(listing) {
        if(listing.latitude && listing.longitude) {
            var price = '$' + utils.abbreviateNumber(listing.asking_price),
                marker = L.marker([listing.latitude, listing.longitude], {
                    icon: new L.DivIcon({
                        className: 'map-marker',
                        html: price,
                        iconSize: [price.length * 8 + 10, 24]
                    })
                });

            var tooltipHtml = listingMapTooltip({
                thumbnail: listing.thumbnails[0],
                price: utils.formatNumber(listing.asking_price),
                address: `${utils.titleCase(listing.full_address)}, ${utils.titleCase(
                    listing.city)}, ${listing.state}, ${listing.zip_code}`,
                bedrooms: listing.beds,
                bathrooms: listing.total_baths,
                residenceSqft: utils.formatNumber(listing.residence_sqft),
                acres: !listing.residence_sqft ? utils.formatNumber(listing.acres) : null
            });

            marker.bindTooltip(tooltipHtml, {
                className: 'map-tooltip',
                direction: 'top',
            });

            marker.on('click', function() {
                window.open('/listing/' + listing.id);
            });

            markers.addLayer(marker);
        }

    });

    map.fitBounds(markers.getBounds());
}

export default {
    init: init,
    refresh: refresh,
    updateListings: updateListings
};