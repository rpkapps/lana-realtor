import '../bootstrap.js';
import '../components/bootpag.js';
import '../components/secondary-nav.js';
import utils from '../utils.js';
import sRets from '../simplyrets.js';
import listingCard from '../templates/listing-card.js';

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
    currentXhr,
    lconfig = {
        $container: $('#cardListings')
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
            title: sRets.determineTitle(listing.property.type),
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
    lconfig.$container.addClass('loading');

    sRets.getListings(
        function(data, textStatus, xhr) {
            updateListingCards(data);
            lconfig.$container.removeClass('loading');
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
    $(window).scrollTop($('#secondaryNav').offset().top);

    getListings();
});

// Secondary Navbar event listener
$.subscribe('snavbar.change ', function() {
    // Set offset back to 0
    gSearchParams.set('offset', sRets.getPageOffset(0, currentXhr));
    history.pushState(null, null, `?${gSearchParams.toString()}`);

    getListings(true);
});

$(window).on('resize', debouncedResize);

getListings(true);
resizePagination();