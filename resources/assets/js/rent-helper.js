import NProgress from 'nprogress';

NProgress.configure({
    showSpinner: false,
    trickleSpeed: gConfig.progressBarSpeed
});

var request = null;

/**
 * Clean query string
 * @param query
 */
function cleanQuery(query) {
    return query.replace(/%5B%5D/g, '');
}

/**
 * Get rent listing
 * @param onDone
 * @param onFail
 * @param query
 */
function getListings(onDone = $.noop, onFail = $.noop, query) {
    query = query || `limit=${gConfig.limit}&${cleanQuery(gSearchParams.toString())}`;
    request = $.ajax({
        type: 'GET',
        url: gConfig.rentApiUrl + `?${query}`,
        dataType: 'json',
        beforeSend: function(xhr) {
            $('body').addClass('loading');
            NProgress.remove();
            NProgress.set(0);
            NProgress.start();

            if(request !== null) {
                request.abort();
            }
        }
    }).done(function() {
        onDone(...arguments);

        $('body').removeClass('loading');
        NProgress.done();
    }).fail(onFail);
}

export default {
    getListings: getListings
};