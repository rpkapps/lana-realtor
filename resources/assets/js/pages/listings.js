import '../bootstrap.js';
import '../components/bootpag.js';
import '../components/filter-bar.js';
import '../components/btn-tabs.js';
import utils from '../utils.js';
import listingCard from '../templates/listing-card.js';
import listingHelper from '../listing-helper.js';

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
    noListingsFoundHtml = `<p class="no-listing-found">Sorry, there are no listings available using those search terms.</p>`,
    currentListings = [],
    $container = $('#cardListings');


/**
 * Update listing cards
 * @param listings
 */
function updateListingCards(listings) {
    currentListings = listings;

    var html = '';

    listings.forEach(function(listing) {
        html += listingCard({
            id: listing.id,
            photo: listing.photos[0],
            title: listing.type === 'Other' ? listing.sale_rent : `${listing.type} ${listing.sale_rent}`,
            price: utils.formatNumber(listing.asking_price),
            address: `${utils.titleCase(listing.full_address)}, ${utils.titleCase(listing.city)}, ${listing.state}, ${listing.zip_code}`,
            bedrooms: listing.beds,
            bathrooms: listing.total_baths,
            residenceSqft: utils.formatNumber(listing.residence_sqft),
            acres: !listing.residence_sqft ? utils.formatNumber(listing.acres) : null
        });
    });

    updateDOM(html);
}

/**
 * Get listings
 * @param resetPagination
 */
function getListings(resetPagination = false) {
    listingHelper.getListings(function(data) {
            updateListingCards(data.data);

            if(resetPagination) {
                // Update total number of pages for pagination
                $pagination.bootpag({
                    page: 1,
                    total: data.meta.last_page,
                    firstLastUse: true
                });
                resizePagination();
            }

            // Handle no data and when there is data, show the pagination
            (data.data.length < 1) ? handleNoData() : $pagination.show();

        },
        function(xhr, textStatus, errorThrown) {
            handleNoData();
            console.error(errorThrown);
        }
    );
}


/* HELPER METHODS
   ================================================== */

function displayGridView() {

}

function displayMapView() {

}

/**
 * Update DOM with new listings
 * @param html
 */
function updateDOM(html) {
    $container.html(html || noListingsFoundHtml);
    blazy.revalidate();
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
    updateDOM();
}

/* MAIN / EVENT HANDLERS
   ================================================== */

debouncedResize = utils.debounce(function() {
    resizePagination();
}, 100);

// Pagination event handler
$pagination.on('page', function(event, page) {
    gSearchParams.set('page', page);
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    // Scroll to top on pagination change
    $('html,body').animate({scrollTop: 0}, 1);

    getListings();
});

// Event listener
$.subscribe('snavbar.change filter.change', function() {
    gSearchParams.set('page', 1);
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    getListings(true);
});

// Handle map and card view btn tabs
$.subscribe('btn-tabs.change', function(event, btn) {
    if(btn.id === 'cardViewBtn') {
        blazy.revalidate();
        gSearchParams.set('view', 'card');
        history.pushState(null, null, `?${gSearchParams.toString()}`);
    }
    if(btn.id === 'mapViewBtn') {
        gSearchParams.set('view', 'map');
        history.pushState(null, null, `?${gSearchParams.toString()}`);
    }
});

$(window).on('resize', debouncedResize);

gConfig.listingApiCategory = utils.getPageName() === 'rent' ? 'rent' : 'buy';
getListings(true);
resizePagination();