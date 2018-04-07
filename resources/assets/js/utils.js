/**
 * Format number to contain commas
 * @param number
 * @returns {string}
 */
function formatNumber(number = 0) {
    return parseFloat(number) ? parseFloat(number).toLocaleString('en') : '';
}

/**
 * Returns a function, that, as long as it continues to be invoked, will not
 * be triggered. The function will be called after it stops being called for
 * N milliseconds. If `immediate` is passed, trigger the function on the
 * leading edge, instead of the trailing.
 * @param func
 * @param wait
 * @param immediate
 * @returns {Function}
 */
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if(!immediate) {
                func.apply(context, args);
            }
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if(callNow) {
            func.apply(context, args);
        }
    };
}

/**
 * Clamp a number
 */
function clamp(number, min, max) {
    return Math.min(Math.max(number, min), max);
}

export default {
    formatNumber: formatNumber,
    debounce: debounce,
    clamp: clamp
};