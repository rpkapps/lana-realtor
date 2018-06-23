require('url-search-params-polyfill');
require('./components/tiny-pub-sub');

window.Blazy = require('blazy');
window.gSearchParams = new URLSearchParams(location.search.slice(1));
window.gConfig = {
    rentApiUrl: '/api/v1/properties',
    simplyRetsApiUrl: 'https://api.simplyrets.com/properties',
    simplyRetsBtoa: btoa('simplyrets:simplyrets'),
    progressBarSpeed: 40,
    limit: 9
};

// refresh page when back button is pressed
$(window).on('popstate', function() {
    window.location.reload();
});