import '../bootstrap.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
import listingCard from '../templates/listing-card.js';

var $checkboxes = $('#homeCheckboxes input'),
    $search = $('#homeSearch'),
    blazy = new Blazy(),
    currentListings,
    lconfig = {
        $container: $('#homeListings')
    };

$('#homeSearchForm').on('submit', function(event) {

    event.preventDefault();

    var urlstr = window.location.origin + '/listings?';
    $checkboxes.each(function() {
        if(this.checked) {
            urlstr += 'type%5B%5D=' + this.value + '&';
        }
    });

    if($search.val()) {
        urlstr += 'q=' + $search.val();
    }

    window.location.href = urlstr;
});

function updateListingCards(listings = []) {
    currentListings = listings;

    var html = '';
    listings.forEach(function(listing) {
        html += listingCard({
            id: listing.mlsId, // change this
            photo: listing.photos[0],
            title: sRets.determineTitle(listing.property.type),
            price: utils.formatNumber(listing.listPrice),
            address: `${listing.address.full}, ${listing.address.city}, ${listing.address.state}`,
            bedrooms: listing.property.bedrooms || '',
            bathrooms: (listing.property.bathsFull || 0) + (listing.property.bathsHalf || 0) + (listing.property.bathsThreeQuarter || 0),
            property: utils.formatNumber(listing.property.area)
        });
    });

    lconfig.$container.html(html);
    blazy.revalidate();
}

function getListings() {
    lconfig.$container.addClass('loading');

    sRets.getListings(
        function(data, textStatus) {
            updateListingCards(data);
            lconfig.$container.removeClass('loading');
        },
        function(textStatus, errorThrown) {
            console.error(errorThrown);
        },
        `limit=${gConfig.limit}`
    );
}

getListings();
