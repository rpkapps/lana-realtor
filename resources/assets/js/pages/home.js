import '../bootstrap.js';
import utils from '../utils.js';
import listingCard from '../templates/listing-card.js';
import listingHelper from '../listing-helper.js';

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

    currentListings.forEach(function(listing) {
        html += listingCard({
            id: listing.id,
            photo: listing.photos[0],
            title: listing.type === 'Other' ? listing.sale_rent : `${listing.type} ${listing.sale_rent}`,
            price: utils.formatNumber(listing.asking_price),
            address: `${utils.titleCase(listing.full_address)}, ${utils.titleCase(listing.city)}, ${listing.state}, ${listing.zip_code}`,
            bedrooms: listing.beds,
            bathrooms: listing.total_baths,
            residenceSqft: utils.formatNumber(listing.residence_sqft),
            buildingSqft: !listing.residence_sqft ? utils.formatNumber(listing.building_sqft) : null,
            acres: (!listing.residence_sqft && !listing.building_sqft) ? utils.formatNumber(listing.acres) : null
        });
    });

    $container.html(html);
    blazy.revalidate();
}

/**
 * Get listings
 */
function getListings() {
    listingHelper.getListings(
        function(data, textStatus) {
            updateListingCards(data.data);
        },
        function(textStatus, errorThrown) {
            console.error(errorThrown);
        }
    );
}

gConfig.listingApiCategory = 'featured';
getListings();
