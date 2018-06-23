import '../bootstrap.js';
import '../components/bootpag.js';
import '../components/filter-bar.js';
import secondaryNav from '../components/secondary-nav.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
import listingCard from '../templates/listing-card.js';
import simplyrets from '../simplyrets';
import rentHelper from '../rent-helper';

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
    view,
    currentXhr,
    $container = $('#cardListings');

/* BUY View METHODS
   ================================================== */
var buyView = {
    /**
     * Update listing cards
     * @param listings
     */
    updateListingCards: function(listings) {
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
                bathrooms: (listing.property.bathsFull || 0) + (listing.property.bathsHalf || 0) +
                (listing.property.bathsThreeQuarter || 0),
                property: utils.formatNumber(listing.property.area)
            });
        });

        updateDOM(html);
    },
    /**
     * Get listings from Simply RETS
     * @param resetPagination
     */
    getListings: function(resetPagination = false) {
        var self = this;

        if(secondaryNav.allUnchecked()) {
            simplyrets.addAllTypesExcept(['rental', 'condominium']);
        }

        sRets.getListings(
            function(data, textStatus, xhr) {
                self.updateListingCards(data);
                currentXhr = xhr;

                if(resetPagination) {
                    // Update total number of pages for pagination
                    $pagination.bootpag({
                        page: 1,
                        total: sRets.getNumberOfPages(currentXhr),
                        firstLastUse: true
                    });
                    resizePagination();
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
    },
    /**
     * Handle anything specific for buy view on paginate
     */
    handlePagination: function(page) {
        // Set new offset
        gSearchParams.set('offset', sRets.getPageOffset(page, currentXhr));
    },
    /**
     * Handle nav and filter bar change for buy view
     */
    handleNavChange: function() {
        // Set offset back to 0
        gSearchParams.set('offset', sRets.getPageOffset(0, currentXhr));
    }
};

/* RENT View METHODS
   ================================================== */

var rentView = {
    /**
     * Update listing cards
     * @param listings
     */
    updateListingCards: function(listings) {
        var html = '';

        listings.forEach(function(listing) {
            var firstPhoto;

            try {
                firstPhoto = JSON.parse(listing.photos)[0];
            }
            catch(e) {
                // If not array - will be a string of one photo or none
                firstPhoto = listing.photos;
            }

            html += listingCard({
                vendor: 'l',
                id: listing.id,
                photo: firstPhoto,
                title: 'House For Rent',
                price: utils.formatNumber(listing.listPrice),
                address: `${listing.streetNumber} ${listing.streetName}, ${listing.city}, ${listing.state}, ${listing.postalCode}`,
                bedrooms: listing.bedrooms || '',
                bathrooms: listing.bathrooms || 0,
                property: utils.formatNumber(listing.area)
            });
        });

        updateDOM(html);
    },
    /**
     * Get listings from Rent API
     * @param resetPagination
     */
    getListings: function(resetPagination = false) {
        var self = this;
        rentHelper.getListings(function(data) {
                self.updateListingCards(data.data);

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
    },
    /**
     * Handle anything specific for rent view on paginate
     */
    handlePagination: function(page) {
        // Set new page
        gSearchParams.set('page', page);
    },
    /**
     * Handle nav and filter bar change for rent view
     */
    handleNavChange: function() {
        // Set page to 1
        gSearchParams.set('page', 1);
    }
};

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

/* MAIN
   ================================================== */

debouncedResize = utils.debounce(function() {
    resizePagination();
}, 100);

// Pagination event handler
$pagination.on('page', function(event, page) {
    view.handlePagination(page);
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    // Scroll to top on pagination change
    $('html,body').animate({scrollTop: 0}, 1);

    view.getListings();
});

// Event listener
$.subscribe('snavbar.change filter.change', function() {
    view.handleNavChange();
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    view.getListings(true);
});

$(window).on('resize', debouncedResize);

view = utils.getPageName() === 'rent' ? rentView : buyView;
view.getListings(true);
resizePagination();