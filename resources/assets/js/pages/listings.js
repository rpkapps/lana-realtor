import '../bootstrap.js';
import '../components/bootpag.js';
import '../components/filter-bar.js';
import '../components/secondary-nav.js';
import '../components/btn-tabs.js';
import utils from '../utils.js';
import listingCard from '../templates/listing-card.js';
import listingHelper from '../listing-helper.js';
import map from '../components/map.js';

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
    $container = $('#cardListings'),
    view;

var cardView = {
    /**
     * Get listings for card view
     * @param resetPagination
     */
    getListings: function(resetPagination = false) {
        var url = gConfig.listingApiBaseUrl + gConfig.listingApiCategory + `?${gSearchParams.toString()}`;

        listingHelper.getListings({
            url: url,
            onSuccess: function(response) {
                updateListingCards(response.data);

                if(resetPagination) {
                    // Update total number of pages for pagination
                    $pagination.bootpag({
                        page: 1,
                        total: response.meta.last_page,
                        firstLastUse: true
                    });
                    resizePagination();
                }

                // Handle no data and when there is data, show the pagination
                (response.data.length < 1) ? handleNoData() : $pagination.show();

            },
            onFail: function(xhr, textStatus, errorThrown) {
                if(textStatus !== 'abort') {
                    handleNoData();
                    console.error(errorThrown);
                }
            }
        });
    }
};

var mapView = {
    /**
     * Get listings for map view
     */
    getListings: function() {
        var url = gConfig.listingApiBaseUrl + gConfig.listingApiCategory + `/map?${gSearchParams.toString()}`;
        listingHelper.getListings({
            url: url,
            onSuccess: function(response) {
                map.updateListings(response.data);
            },
            onFail: function(xhr, textStatus, errorThrown) {
                if(textStatus !== 'abort') {

                }
            }
        });
    }
};

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

/* HELPER METHODS
   ================================================== */

function setCardView() {
    view = cardView;
    view.getListings(true);
    blazy.revalidate();
    gSearchParams.set('view', 'card');
    history.pushState(null, null, `?${gSearchParams.toString()}`);
}

function setMapView() {
    view = mapView;
    view.getListings();
    gSearchParams.set('view', 'map');
    history.pushState(null, null, `?${gSearchParams.toString()}`);
    map.init();
    map.refresh();
    map.updateListings(currentListings);
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

    view.getListings();
});

// Event listener
$.subscribe('snavbar.change filter.change', function() {
    gSearchParams.set('page', 1);
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    view.getListings(true);
});

// Handle map and card view btn tabs
$.subscribe('btn-tabs.change', function(event, btn) {
    if(btn.id === 'cardViewBtn') {
        setCardView();
    }
    if(btn.id === 'mapViewBtn') {
        setMapView();
    }
});

$(window).on('resize', debouncedResize);

gConfig.listingApiCategory = utils.getPageName() === 'rent' ? 'rent' : 'buy';
view = gSearchParams.get('view') === 'map' ? mapView : cardView;

view.getListings(true);
resizePagination();

if(gSearchParams.get('view') === 'map') {
    map.init();
}