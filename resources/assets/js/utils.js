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

/**
 * Get page name from the URL buy getting the last portion after the slash
 * i.e.: for www.domain.com/path1/path2 the page name would be path2
 * @returns {*}
 */
function getPageName() {
    var path = window.location.pathname.split('/');
    return path.length ? path[path.length - 1] : '';
}

/**
 * Add commas to number
 * @param number
 * @returns {string}
 */
function numberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Convert string to title case
 * @param string
 */
function titleCase(string) {
    return string.toLowerCase().split(/ +/g).map(function(word) {
        return word.replace(word[0], word[0].toUpperCase());
    }).join(' ');
}

/**
 * Abbreviate number (i.e. 1000 to 1k, 1000000 to 1m, etc.)
 * taken from: https://stackoverflow.com/questions/12900332/how-do-i-round-millions-and-thousands-in-javascript
 * @param value
 * @returns {string}
 */
function abbreviateNumber(value) {
    if(isNaN(value)) return value;

    if(value < 9999) {
        return value;
    }

    if(value < 1000000) {
        return Math.round(value/1000) + "k";
    }
    if( value < 10000000) {
        return (value/1000000).toFixed(2) + "m";
    }

    if(value < 1000000000) {
        return Math.round((value/1000000)) + "m";
    }

    if(value < 1000000000000) {
        return Math.round((value/1000000000)) + "b";
    }

    return "1T+";
}

export default {
    formatNumber: formatNumber,
    debounce: debounce,
    clamp: clamp,
    getPageName: getPageName,
    numberWithCommas: numberWithCommas,
    titleCase: titleCase,
    abbreviateNumber: abbreviateNumber
};