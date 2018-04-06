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
        url: gConfig.simplyRetsApiUrl + '?' + cleanQuery(gSearchParams.toString()),
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
function determineTitle(type = '')
{
    var types = {
        'RES': 'House For Sale',
        'RNT': 'House For Rent',
        'MLF': 'House For Sale',
        'CRE': 'Commercial Building For Sale',
        'LND': 'Land For Sale',
        'FRM': 'Farm For Sale',
    };

    return types[type] ? types[type] : 'Invalid Listing';
}

export default {
    getListings: getListings,
    determineTitle: determineTitle
};
