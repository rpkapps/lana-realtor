import NProgress from 'nprogress';

NProgress.configure({
    showSpinner: false,
    trickleSpeed: gConfig.progressBarSpeed
});

var request = null;

/**
 * Get listing
 * @param url
 * @param onDone
 * @param onFail
 */
function getListings({url, onSuccess = $.noop, onFail = $.noop}) {
    request = $.ajax({
        type: 'GET',
        url: url,
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
        onSuccess(...arguments);

        $('body').removeClass('loading');
        NProgress.done();
    }).fail(onFail);
}

export default {
    getListings: getListings
};