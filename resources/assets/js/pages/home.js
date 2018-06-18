import '../bootstrap.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
import listingCard from '../templates/listing-card.js';

var $checkboxesContainer = $('#homeCheckboxes'),
    $checkboxes = $('#homeCheckboxes input'),
    $tabs = $('#homeNavTabs .nav-link'),
    $search = $('#homeSearch'),
    blazy = new Blazy(),
    currentListings,
    $container = $('#homeListings');


$('#homeSearchForm').on('submit', function(event) {
    var page = $tabs.filter('#homeNavRent.active').length ? 'rent' : 'buy',
        path = `/${page}`,
        values = [];

    event.preventDefault();

    if(page === 'buy') {
        $checkboxes.filter(':checked').each(function() {
            values.push('type%5B%5D=' + this.value);
        });
    }

    if($search.val()) {
        values.push('q=' + $search.val());
    }

    window.location.href = values.length ? path + '?' + values.join('&') : path;
});

$tabs.on('show.bs.tab', function(event) {
    $checkboxesContainer.css('display', this.id === 'homeNavRent' ? 'none' : '');
});

/**
 * Update listings
 * @param listings
 */
function updateListingCards(listings = []) {
    currentListings = listings;

    var html = '';
    listings.forEach(function(listing) {
        html += listingCard({
            vendor: 'm',
            id: listing.mlsId, // change this
            photo: listing.photos[0],
            title: sRets.determineTitle(listing.property.type),
            price: utils.formatNumber(listing.listPrice),
            address: `${listing.address.full}, ${listing.address.city}, ${listing.address.state}, ${listing.address.postalCode}`,
            bedrooms: listing.property.bedrooms || '',
            bathrooms: (listing.property.bathsFull || 0) + (listing.property.bathsHalf || 0) + (listing.property.bathsThreeQuarter || 0),
            property: utils.formatNumber(listing.property.area)
        });
    });

    $container.html(html);
    blazy.revalidate();
}

/**
 * Get listings
 */
function getListings() {
    sRets.getListings(
        function(data, textStatus) {
            updateListingCards(data);
        },
        function(textStatus, errorThrown) {
            console.error(errorThrown);
        },
        `limit=${gConfig.limit}`
    );
}

getListings();
