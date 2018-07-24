require('url-search-params-polyfill');
require('./components/tiny-pub-sub');

window.Blazy = require('blazy');
window.gSearchParams = new URLSearchParams(location.search.slice(1));
window.gConfig = {
    listingApiBaseUrl: '/api/v1/listings/',
    listingApiCategory: 'featured',
    progressBarSpeed: 40
};

// refresh page when back button is pressed
$(window).on('popstate', function() {
    window.location.reload();
});