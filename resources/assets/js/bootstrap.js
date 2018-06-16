require('url-search-params-polyfill');
require('./components/tiny-pub-sub');

window.Blazy = require('blazy');
window.gSearchParams = new URLSearchParams(location.search.slice(1));
window.gConfig = {
    simplyRetsApiUrl: 'https://api.simplyrets.com/properties',
    simplyRetsBtoa: btoa('simplyrets:simplyrets'),
    progressBarSpeed: 40,
    noListingsFoundHtml: `<p class="no-listing-found">Sorry, there are no listings available using those search terms.</p>`,
    limit: 9
};