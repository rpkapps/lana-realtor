import '../bootstrap.js';
import '../components/secondary-nav.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
import listingCard from '../templates/listing-card.js';
import simplyrets from '../simplyrets';

var blazy = new Blazy(),
    lconfig = {
        $container: $('#cardListings'),
    };

/**
 * Update listings
 * @param listings
 */
function updateListingCards(listings = []) {
    var html = '';
    listings.forEach(function(listing) {
        html += listingCard({
            photo: listing.photos[0],
            title: simplyrets.determineTitle(listing.property.type),
            price: utils.formatNumber(listing.listPrice),
            address: `${listing.address.full}, ${listing.address.city}, ${listing.address.state}`,
            bedrooms: listing.property.bedrooms || '',
            bathrooms: listing.property.bathrooms || '',
            property: utils.formatNumber(listing.property.area)
        });
    });

    lconfig.$container.html(html);
    blazy.revalidate();
}

/**
 * Get listings from Simply RETS
 */
function getListings() {
    lconfig.$container.addClass('loading');
    sRets.getListings(
        function(data, textStatus, jqXHR) {
            updateListingCards(data);
            lconfig.$container.removeClass('loading');
        },
        function(jqXHR, textStatus, errorThrown) {
            console.error(errorThrown);
        }
    );

}

getListings();
$.subscribe('snavbar.change ', getListings);
