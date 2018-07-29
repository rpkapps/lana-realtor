import utils from '../utils.js';
import listingMapTooltip from '../templates/listing-map-tooltip.js';

var mapCenter = [65.339248, -150.885501],
    maxBounds = L.latLngBounds([
        [72, -173],
        [52, -139]
    ]),
    zoomPadding = [50, 50],
    map = null,
    markers = L.markerClusterGroup();

function init() {
    if(!map) {
        map = L.map('mapView', {
            maxBounds: maxBounds,
            maxZoom: 18,
            minZoom: 3,
            zoomSnap: 0.1
        }).setView(mapCenter, 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoicnBrb2xlc25payIsImEiOiJjams1bnlyaGowdmdhM3BuY3B6dTY1em1yIn0.lJw7tKQ_2H0M1K-PiMtXNQ'
        }).addTo(map);

        map.addLayer(markers);

        markers.on('clusterclick', function(event) {
            event.layer.zoomToBounds({padding: zoomPadding});
        });
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
            if(!maxBounds.contains([listing.latitude, listing.longitude])) {
                console.log('Listing outside of bounds:', listing);
                return;
            }

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
                className: 'map-tooltip'
            });

            marker.on('click', function() {
                window.open('/listing/' + listing.id);
            });

            markers.addLayer(marker);
        }

    });

    var markerBounds = markers.getBounds();
    var bounds = markerBounds._southWest ? markerBounds : maxBounds;
    map.fitBounds(bounds, {padding: zoomPadding});
}

export default {
    init: init,
    refresh: refresh,
    updateListings: updateListings
};