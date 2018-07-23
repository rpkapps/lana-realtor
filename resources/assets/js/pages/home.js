import '../bootstrap.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
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
        var firstPhoto;

        try {
            firstPhoto = JSON.parse(listing.photos)[0];
        }
        catch(e){
            // If not array - will be a string of one photo or none
            firstPhoto = listing.photos;
        }

        html += listingCard({
            vendor: 'l',
            id: listing.id,
            photo: firstPhoto,
            title: listing.sale_rent,
            price: utils.formatNumber(listing.asking_price),
            address: `${listing.full_address}, ${listing.city}, ${listing.state}, ${listing.zip_code}`,
            bedrooms: listing.beds || '',
            bathrooms: (listing.full_baths || 0) + (listing.partial_baths || 0),
            property: utils.formatNumber(listing.residence_sqft)
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
        },
        `limit=${gConfig.limit}`
    );
}

getListings();
