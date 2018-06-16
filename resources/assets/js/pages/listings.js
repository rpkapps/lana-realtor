import '../bootstrap.js';
import '../components/bootpag.js';
import '../components/filter-bar.js';
import secondaryNav from '../components/secondary-nav.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
import listingCard from '../templates/listing-card.js';
import simplyrets from '../simplyrets';


var blazy = new Blazy(),
    debouncedResize,
    $pagination = $('#pagination').bootpag({
        total: 0,
        page: 0,
        maxVisible: 3,
        leaps: true,
        firstLastUse: true,
        first: '←',
        last: '→',
        wrapClass: 'pagination',
        activeClass: 'active',
        disabledClass: 'disabled',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first'
    }),
    currentListings = [],
    currentXhr,
    $container = $('#cardListings');

/**
 * Update listings
 * @param listings
 */
function updateListingCards(listings = []) {
    currentListings = listings;

    var html = '';
    listings.forEach(function(listing) {
        html += listingCard({
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

    $container.html(html || gConfig.noListingsFoundHtml);
    blazy.revalidate();
}

function displayGridView() {

}

function displayMapView() {

}

function displayListing() {

}

/**
 * Resize pagination
 */
function resizePagination() {
    $pagination.bootpag({
        maxVisible: window.innerWidth > 767 ? 5 : 3
    });
}

/**
 * Handle empty data
 */
function handleNoData() {
    $pagination.hide();
}

/**
 * Get listings from Simply RETS
 */
function getListings(resetPagination = false) {


    if(secondaryNav.allUnchecked()) {
        simplyrets.addAllTypesExcept(['rental', 'condominium']);
    }

    sRets.getListings(
        function(data, textStatus, xhr) {
            updateListingCards(data);
            currentXhr = xhr;

            if(resetPagination) {
                // Update total number of pages for pagination
                $pagination.bootpag({
                    page: 1,
                    total: sRets.getNumberOfPages(currentXhr),
                    firstLastUse: true
                });
            }

            // Handle no data and when there is data, show the pagination
            (data.length < 1) ? handleNoData() : $pagination.show();
        },
        function(xhr, textStatus, errorThrown) {
            currentXhr = xhr;
            handleNoData();
            console.error(errorThrown);
        }
    );
}

/* MAIN
   ================================================== */

debouncedResize = utils.debounce(function() {
    resizePagination();
}, 100);

// Pagination event handler
$pagination.on('page', function(event, page) {
    // Set new offset
    gSearchParams.set('offset', sRets.getPageOffset(page, currentXhr));
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    // Scroll to top on pagination change
    $('html,body').animate({scrollTop: 0}, 1);

    getListings();
});

// Event listener
$.subscribe('snavbar.change filter.change', function() {
    // Set offset back to 0
    gSearchParams.set('offset', sRets.getPageOffset(0, currentXhr));
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    getListings(true);
});

$(window).on('resize', debouncedResize);

getListings(true);
resizePagination();