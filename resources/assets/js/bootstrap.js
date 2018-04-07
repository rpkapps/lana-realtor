require('url-search-params-polyfill');
require('./components/tiny-pub-sub');

window.Blazy = require('blazy');
window.gSearchParams = new URLSearchParams(location.search.slice(1));
window.gConfig = {
    simplyRetsApiUrl: 'https://api.simplyrets.com/properties',
    simplyRetsBtoa: btoa('simplyrets:simplyrets'),
    limit: 3
};