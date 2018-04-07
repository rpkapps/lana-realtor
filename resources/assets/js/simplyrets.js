import utils from './utils.js';

/**
 * Clean query string
 * @param query
 */
function cleanQuery(query) {
    return query.replace(/%5B%5D/g, '');
}

/**
 * Get property listings from Simply RETS
 * @param data
 * @param onDone
 * @param onFail
 */
function getListings(onDone = $.noop, onFail = $.noop) {
    $.ajax({
        type: 'GET',
        url: gConfig.simplyRetsApiUrl + `?limit=${gConfig.limit}&${cleanQuery(gSearchParams.toString())}`,
        dataType: 'json',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', `Basic ${gConfig.simplyRetsBtoa}`);
        }
    }).done(onDone).fail(onFail);
}

/**
 * Determine listing title
 * @param type
 * @returns {string}
 */
function determineTitle(type = '') {
    var types = {
        'RES': 'House For Sale',
        'RNT': 'House For Rent',
        'MLF': 'House For Sale',
        'CRE': 'Commercial Building For Sale',
        'LND': 'Land For Sale',
        'FRM': 'Farm For Sale'
    };

    return types[type] ? types[type] : 'Invalid Listing';
}

/**
 * Parse response header
 * @param xhr
 * @returns {{offset: number, limit: number}}
 */
function parseXhr(xhr) {
    var link = xhr.getResponseHeader('link') || '?',
        searchParams = new URLSearchParams(link.match(/\?.*/)[0]);

    return {
        offset: parseInt(searchParams.get('offset'), 10) || parseInt(gSearchParams.get('offset'), 10),
        limit: parseInt(searchParams.get('limit'), 10) || gConfig.limit,
        total: parseInt(xhr.getResponseHeader('x-total-count'), 10)
    };
}

/**
 * Get number of pages
 * @param xhr
 * @returns {number}
 */
function getNumberOfPages(xhr, paginate) {
    var paginate = paginate || parseXhr(xhr);

    return Math.ceil(paginate.total / paginate.limit);
}

/**
 * Get the page offset given a page number
 * @param page
 * @param xhr
 */
function getPageOffset(page, xhr) {
    var paginate = parseXhr(xhr),
        offset = (page - 1) * paginate.limit,
        maxOffset = getNumberOfPages(xhr, paginate) * paginate.limit;

    return utils.clamp(offset, 0, maxOffset);
}

export default {
    getListings: getListings,
    determineTitle: determineTitle,
    parseXhr: parseXhr,
    getPageOffset: getPageOffset,
    getNumberOfPages: getNumberOfPages
};
