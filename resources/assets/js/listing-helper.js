import NProgress from 'nprogress';

NProgress.configure({
    showSpinner: false,
    trickleSpeed: gConfig.progressBarSpeed
});

var request = null;

/**
 * Get listing
 * @param onDone
 * @param onFail
 * @param query
 */
function getListings(onDone = $.noop, onFail = $.noop, query) {
    query = query || gSearchParams.toString();
    request = $.ajax({
        type: 'GET',
        url: gConfig.listingApiBaseUrl + gConfig.listingApiCategory + `?${query}`,
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