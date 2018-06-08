/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * Format number to contain commas
 * @param number
 * @returns {string}
 */
function formatNumber() {
    var number = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

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
    return function () {
        var context = this,
            args = arguments;
        var later = function later() {
            timeout = null;
            if (!immediate) {
                func.apply(context, args);
            }
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) {
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

/* harmony default export */ __webpack_exports__["a"] = ({
    formatNumber: formatNumber,
    debounce: debounce,
    clamp: clamp
});

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(2);
__webpack_require__(4);

window.Blazy = __webpack_require__(5);
window.gSearchParams = new URLSearchParams(location.search.slice(1));
window.gConfig = {
    simplyRetsApiUrl: 'https://api.simplyrets.com/properties',
    simplyRetsBtoa: btoa('simplyrets:simplyrets'),
    limit: 9
};

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {/**
 *
 *
 * @author Jerry Bendy <jerry@icewingcc.com>
 * @licence MIT
 *
 */

(function(self) {
    'use strict';

    var nativeURLSearchParams = self.URLSearchParams ? self.URLSearchParams : null,
        isSupportObjectConstructor = nativeURLSearchParams && (new nativeURLSearchParams({a: 1})).toString() === 'a=1',
        // There is a bug in safari 10.1 (and earlier) that incorrectly decodes `%2B` as an empty space and not a plus.
        decodesPlusesCorrectly = nativeURLSearchParams && (new nativeURLSearchParams('s=%2B').get('s') === '+'),
        __URLSearchParams__ = "__URLSearchParams__",
        prototype = URLSearchParamsPolyfill.prototype,
        iterable = !!(self.Symbol && self.Symbol.iterator);

    if (nativeURLSearchParams && isSupportObjectConstructor && decodesPlusesCorrectly) {
        return;
    }


    /**
     * Make a URLSearchParams instance
     *
     * @param {object|string|URLSearchParams} search
     * @constructor
     */
    function URLSearchParamsPolyfill(search) {
        search = search || "";

        // support construct object with another URLSearchParams instance
        if (search instanceof URLSearchParams || search instanceof URLSearchParamsPolyfill) {
            search = search.toString();
        }
        this [__URLSearchParams__] = parseToDict(search);
    }


    /**
     * Appends a specified key/value pair as a new search parameter.
     *
     * @param {string} name
     * @param {string} value
     */
    prototype.append = function(name, value) {
        appendTo(this [__URLSearchParams__], name, value);
    };

    /**
     * Deletes the given search parameter, and its associated value,
     * from the list of all search parameters.
     *
     * @param {string} name
     */
    prototype.delete = function(name) {
        delete this [__URLSearchParams__] [name];
    };

    /**
     * Returns the first value associated to the given search parameter.
     *
     * @param {string} name
     * @returns {string|null}
     */
    prototype.get = function(name) {
        var dict = this [__URLSearchParams__];
        return name in dict ? dict[name][0] : null;
    };

    /**
     * Returns all the values association with a given search parameter.
     *
     * @param {string} name
     * @returns {Array}
     */
    prototype.getAll = function(name) {
        var dict = this [__URLSearchParams__];
        return name in dict ? dict [name].slice(0) : [];
    };

    /**
     * Returns a Boolean indicating if such a search parameter exists.
     *
     * @param {string} name
     * @returns {boolean}
     */
    prototype.has = function(name) {
        return name in this [__URLSearchParams__];
    };

    /**
     * Sets the value associated to a given search parameter to
     * the given value. If there were several values, delete the
     * others.
     *
     * @param {string} name
     * @param {string} value
     */
    prototype.set = function set(name, value) {
        this [__URLSearchParams__][name] = ['' + value];
    };

    /**
     * Returns a string containg a query string suitable for use in a URL.
     *
     * @returns {string}
     */
    prototype.toString = function() {
        var dict = this[__URLSearchParams__], query = [], i, key, name, value;
        for (key in dict) {
            name = encode(key);
            for (i = 0, value = dict[key]; i < value.length; i++) {
                query.push(name + '=' + encode(value[i]));
            }
        }
        return query.join('&');
    };

    // There is a bug in Safari 10.1 and `Proxy`ing it is not enough.
    var forSureUsePolyfill = !decodesPlusesCorrectly;
    var useProxy = (!forSureUsePolyfill && nativeURLSearchParams && !isSupportObjectConstructor && self.Proxy)
    /*
     * Apply polifill to global object and append other prototype into it
     */
    self.URLSearchParams = useProxy ?
        // Safari 10.0 doesn't support Proxy, so it won't extend URLSearchParams on safari 10.0
        new Proxy(nativeURLSearchParams, {
            construct: function(target, args) {
                return new target((new URLSearchParamsPolyfill(args[0]).toString()));
            }
        }) :
        URLSearchParamsPolyfill;


    var USPProto = self.URLSearchParams.prototype;

    USPProto.polyfill = true;

    /**
     *
     * @param {function} callback
     * @param {object} thisArg
     */
    USPProto.forEach = USPProto.forEach || function(callback, thisArg) {
        var dict = parseToDict(this.toString());
        Object.getOwnPropertyNames(dict).forEach(function(name) {
            dict[name].forEach(function(value) {
                callback.call(thisArg, value, name, this);
            }, this);
        }, this);
    };

    /**
     * Sort all name-value pairs
     */
    USPProto.sort = USPProto.sort || function() {
        var dict = parseToDict(this.toString()), keys = [], k, i, j;
        for (k in dict) {
            keys.push(k);
        }
        keys.sort();

        for (i = 0; i < keys.length; i++) {
            this.delete(keys[i]);
        }
        for (i = 0; i < keys.length; i++) {
            var key = keys[i], values = dict[key];
            for (j = 0; j < values.length; j++) {
                this.append(key, values[j]);
            }
        }
    };

    /**
     * Returns an iterator allowing to go through all keys of
     * the key/value pairs contained in this object.
     *
     * @returns {function}
     */
    USPProto.keys = USPProto.keys || function() {
        var items = [];
        this.forEach(function(item, name) {
            items.push([name]);
        });
        return makeIterator(items);
    };

    /**
     * Returns an iterator allowing to go through all values of
     * the key/value pairs contained in this object.
     *
     * @returns {function}
     */
    USPProto.values = USPProto.values || function() {
        var items = [];
        this.forEach(function(item) {
            items.push([item]);
        });
        return makeIterator(items);
    };

    /**
     * Returns an iterator allowing to go through all key/value
     * pairs contained in this object.
     *
     * @returns {function}
     */
    USPProto.entries = USPProto.entries || function() {
        var items = [];
        this.forEach(function(item, name) {
            items.push([name, item]);
        });
        return makeIterator(items);
    };


    if (iterable) {
        USPProto[self.Symbol.iterator] = USPProto[self.Symbol.iterator] || USPProto.entries;
    }


    function encode(str) {
        var replace = {
            '!': '%21',
            "'": '%27',
            '(': '%28',
            ')': '%29',
            '~': '%7E',
            '%20': '+',
            '%00': '\x00'
        };
        return encodeURIComponent(str).replace(/[!'\(\)~]|%20|%00/g, function(match) {
            return replace[match];
        });
    }

    function decode(str) {
        return decodeURIComponent(str.replace(/\+/g, ' '));
    }

    function makeIterator(arr) {
        var iterator = {
            next: function() {
                var value = arr.shift();
                return {done: value === undefined, value: value};
            }
        };

        if (iterable) {
            iterator[self.Symbol.iterator] = function() {
                return iterator;
            };
        }

        return iterator;
    }

    function parseToDict(search) {
        var dict = {};

        if (typeof search === "object") {
            for (var key in search) {
                if (search.hasOwnProperty(key)) {
                    appendTo(dict, key, search[key])
                }
            }

        } else {
            // remove first '?'
            if (search.indexOf("?") === 0) {
                search = search.slice(1);
            }

            var pairs = search.split("&");
            for (var j = 0; j < pairs.length; j++) {
                var value = pairs [j],
                    index = value.indexOf('=');

                if (-1 < index) {
                    appendTo(dict, decode(value.slice(0, index)), decode(value.slice(index + 1)));

                } else {
                    if (value) {
                        appendTo(dict, decode(value), '');
                    }
                }
            }
        }

        return dict;
    }

    function appendTo(dict, name, value) {
        var val = typeof value === 'string' ? value : (
            value !== null && typeof value.toString === 'function' ? value.toString() : JSON.stringify(value)
        )

        if (name in dict) {
            dict[name].push(val);
        } else {
            dict[name] = [val];
        }
    }

})(typeof global !== 'undefined' ? global : (typeof window !== 'undefined' ? window : this));

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(3)))

/***/ }),
/* 3 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 4 */
/***/ (function(module, exports) {

/* jQuery Tiny Pub/Sub - v0.7 - 10/27/2011
 * http://benalman.com/
 * Copyright (c) 2011 "Cowboy" Ben Alman; Licensed MIT, GPL */
(function ($) {

    var o = $({});

    $.subscribe = function () {
        o.on.apply(o, arguments);
    };

    $.unsubscribe = function () {
        o.off.apply(o, arguments);
    };

    $.publish = function () {
        o.trigger.apply(o, arguments);
    };
})(jQuery);

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  hey, [be]Lazy.js - v1.8.2 - 2016.10.25
  A fast, small and dependency free lazy load script (https://github.com/dinbror/blazy)
  (c) Bjoern Klinggaard - @bklinggaard - http://dinbror.dk/blazy
*/
;
(function(root, blazy) {
    if (true) {
        // AMD. Register bLazy as an anonymous module
        !(__WEBPACK_AMD_DEFINE_FACTORY__ = (blazy),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports === 'object') {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = blazy();
    } else {
        // Browser globals. Register bLazy on window
        root.Blazy = blazy();
    }
})(this, function() {
    'use strict';

    //private vars
    var _source, _viewport, _isRetina, _supportClosest, _attrSrc = 'src', _attrSrcset = 'srcset';

    // constructor
    return function Blazy(options) {
        //IE7- fallback for missing querySelectorAll support
        if (!document.querySelectorAll) {
            var s = document.createStyleSheet();
            document.querySelectorAll = function(r, c, i, j, a) {
                a = document.all, c = [], r = r.replace(/\[for\b/gi, '[htmlFor').split(',');
                for (i = r.length; i--;) {
                    s.addRule(r[i], 'k:v');
                    for (j = a.length; j--;) a[j].currentStyle.k && c.push(a[j]);
                    s.removeRule(0);
                }
                return c;
            };
        }

        //options and helper vars
        var scope = this;
        var util = scope._util = {};
        util.elements = [];
        util.destroyed = true;
        scope.options = options || {};
        scope.options.error = scope.options.error || false;
        scope.options.offset = scope.options.offset || 100;
        scope.options.root = scope.options.root || document;
        scope.options.success = scope.options.success || false;
        scope.options.selector = scope.options.selector || '.b-lazy';
        scope.options.separator = scope.options.separator || '|';
        scope.options.containerClass = scope.options.container;
        scope.options.container = scope.options.containerClass ? document.querySelectorAll(scope.options.containerClass) : false;
        scope.options.errorClass = scope.options.errorClass || 'b-error';
        scope.options.breakpoints = scope.options.breakpoints || false;
        scope.options.loadInvisible = scope.options.loadInvisible || false;
        scope.options.successClass = scope.options.successClass || 'b-loaded';
        scope.options.validateDelay = scope.options.validateDelay || 25;
        scope.options.saveViewportOffsetDelay = scope.options.saveViewportOffsetDelay || 50;
        scope.options.srcset = scope.options.srcset || 'data-srcset';
        scope.options.src = _source = scope.options.src || 'data-src';
        _supportClosest = Element.prototype.closest;
        _isRetina = window.devicePixelRatio > 1;
        _viewport = {};
        _viewport.top = 0 - scope.options.offset;
        _viewport.left = 0 - scope.options.offset;


        /* public functions
         ************************************/
        scope.revalidate = function() {
            initialize(scope);
        };
        scope.load = function(elements, force) {
            var opt = this.options;
            if (elements && elements.length === undefined) {
                loadElement(elements, force, opt);
            } else {
                each(elements, function(element) {
                    loadElement(element, force, opt);
                });
            }
        };
        scope.destroy = function() {            
            var util = scope._util;
            if (scope.options.container) {
                each(scope.options.container, function(object) {
                    unbindEvent(object, 'scroll', util.validateT);
                });
            }
            unbindEvent(window, 'scroll', util.validateT);
            unbindEvent(window, 'resize', util.validateT);
            unbindEvent(window, 'resize', util.saveViewportOffsetT);
            util.count = 0;
            util.elements.length = 0;
            util.destroyed = true;
        };

        //throttle, ensures that we don't call the functions too often
        util.validateT = throttle(function() {
            validate(scope);
        }, scope.options.validateDelay, scope);
        util.saveViewportOffsetT = throttle(function() {
            saveViewportOffset(scope.options.offset);
        }, scope.options.saveViewportOffsetDelay, scope);
        saveViewportOffset(scope.options.offset);

        //handle multi-served image src (obsolete)
        each(scope.options.breakpoints, function(object) {
            if (object.width >= window.screen.width) {
                _source = object.src;
                return false;
            }
        });

        // start lazy load
        setTimeout(function() {
            initialize(scope);
        }); // "dom ready" fix

    };


    /* Private helper functions
     ************************************/
    function initialize(self) {
        var util = self._util;
        // First we create an array of elements to lazy load
        util.elements = toArray(self.options);
        util.count = util.elements.length;
        // Then we bind resize and scroll events if not already binded
        if (util.destroyed) {
            util.destroyed = false;
            if (self.options.container) {
                each(self.options.container, function(object) {
                    bindEvent(object, 'scroll', util.validateT);
                });
            }
            bindEvent(window, 'resize', util.saveViewportOffsetT);
            bindEvent(window, 'resize', util.validateT);
            bindEvent(window, 'scroll', util.validateT);
        }
        // And finally, we start to lazy load.
        validate(self);
    }

    function validate(self) {
        var util = self._util;
        for (var i = 0; i < util.count; i++) {
            var element = util.elements[i];
            if (elementInView(element, self.options) || hasClass(element, self.options.successClass)) {
                self.load(element);
                util.elements.splice(i, 1);
                util.count--;
                i--;
            }
        }
        if (util.count === 0) {
            self.destroy();
        }
    }

    function elementInView(ele, options) {
        var rect = ele.getBoundingClientRect();

        if(options.container && _supportClosest){
            // Is element inside a container?
            var elementContainer = ele.closest(options.containerClass);
            if(elementContainer){
                var containerRect = elementContainer.getBoundingClientRect();
                // Is container in view?
                if(inView(containerRect, _viewport)){
                    var top = containerRect.top - options.offset;
                    var right = containerRect.right + options.offset;
                    var bottom = containerRect.bottom + options.offset;
                    var left = containerRect.left - options.offset;
                    var containerRectWithOffset = {
                        top: top > _viewport.top ? top : _viewport.top,
                        right: right < _viewport.right ? right : _viewport.right,
                        bottom: bottom < _viewport.bottom ? bottom : _viewport.bottom,
                        left: left > _viewport.left ? left : _viewport.left
                    };
                    // Is element in view of container?
                    return inView(rect, containerRectWithOffset);
                } else {
                    return false;
                }
            }
        }      
        return inView(rect, _viewport);
    }

    function inView(rect, viewport){
        // Intersection
        return rect.right >= viewport.left &&
               rect.bottom >= viewport.top && 
               rect.left <= viewport.right && 
               rect.top <= viewport.bottom;
    }

    function loadElement(ele, force, options) {
        // if element is visible, not loaded or forced
        if (!hasClass(ele, options.successClass) && (force || options.loadInvisible || (ele.offsetWidth > 0 && ele.offsetHeight > 0))) {
            var dataSrc = getAttr(ele, _source) || getAttr(ele, options.src); // fallback to default 'data-src'
            if (dataSrc) {
                var dataSrcSplitted = dataSrc.split(options.separator);
                var src = dataSrcSplitted[_isRetina && dataSrcSplitted.length > 1 ? 1 : 0];
                var srcset = getAttr(ele, options.srcset);
                var isImage = equal(ele, 'img');
                var parent = ele.parentNode;
                var isPicture = parent && equal(parent, 'picture');
                // Image or background image
                if (isImage || ele.src === undefined) {
                    var img = new Image();
                    // using EventListener instead of onerror and onload
                    // due to bug introduced in chrome v50 
                    // (https://productforums.google.com/forum/#!topic/chrome/p51Lk7vnP2o)
                    var onErrorHandler = function() {
                        if (options.error) options.error(ele, "invalid");
                        addClass(ele, options.errorClass);
                        unbindEvent(img, 'error', onErrorHandler);
                        unbindEvent(img, 'load', onLoadHandler);
                    };
                    var onLoadHandler = function() {
                        // Is element an image
                        if (isImage) {
                            if(!isPicture) {
                                handleSources(ele, src, srcset);
                            }
                        // or background-image
                        } else {
                            ele.style.backgroundImage = 'url("' + src + '")';
                        }
                        itemLoaded(ele, options);
                        unbindEvent(img, 'load', onLoadHandler);
                        unbindEvent(img, 'error', onErrorHandler);
                    };
                    
                    // Picture element
                    if (isPicture) {
                        img = ele; // Image tag inside picture element wont get preloaded
                        each(parent.getElementsByTagName('source'), function(source) {
                            handleSource(source, _attrSrcset, options.srcset);
                        });
                    }
                    bindEvent(img, 'error', onErrorHandler);
                    bindEvent(img, 'load', onLoadHandler);
                    handleSources(img, src, srcset); // Preload

                } else { // An item with src like iframe, unity games, simpel video etc
                    ele.src = src;
                    itemLoaded(ele, options);
                }
            } else {
                // video with child source
                if (equal(ele, 'video')) {
                    each(ele.getElementsByTagName('source'), function(source) {
                        handleSource(source, _attrSrc, options.src);
                    });
                    ele.load();
                    itemLoaded(ele, options);
                } else {
                    if (options.error) options.error(ele, "missing");
                    addClass(ele, options.errorClass);
                }
            }
        }
    }

    function itemLoaded(ele, options) {
        addClass(ele, options.successClass);
        if (options.success) options.success(ele);
        // cleanup markup, remove data source attributes
        removeAttr(ele, options.src);
        removeAttr(ele, options.srcset);
        each(options.breakpoints, function(object) {
            removeAttr(ele, object.src);
        });
    }

    function handleSource(ele, attr, dataAttr) {
        var dataSrc = getAttr(ele, dataAttr);
        if (dataSrc) {
            setAttr(ele, attr, dataSrc);
            removeAttr(ele, dataAttr);
        }
    }

    function handleSources(ele, src, srcset){
        if(srcset) {
            setAttr(ele, _attrSrcset, srcset); //srcset
        }
        ele.src = src; //src 
    }

    function setAttr(ele, attr, value){
        ele.setAttribute(attr, value);
    }

    function getAttr(ele, attr) {
        return ele.getAttribute(attr);
    }

    function removeAttr(ele, attr){
        ele.removeAttribute(attr); 
    }

    function equal(ele, str) {
        return ele.nodeName.toLowerCase() === str;
    }

    function hasClass(ele, className) {
        return (' ' + ele.className + ' ').indexOf(' ' + className + ' ') !== -1;
    }

    function addClass(ele, className) {
        if (!hasClass(ele, className)) {
            ele.className += ' ' + className;
        }
    }

    function toArray(options) {
        var array = [];
        var nodelist = (options.root).querySelectorAll(options.selector);
        for (var i = nodelist.length; i--; array.unshift(nodelist[i])) {}
        return array;
    }

    function saveViewportOffset(offset) {
        _viewport.bottom = (window.innerHeight || document.documentElement.clientHeight) + offset;
        _viewport.right = (window.innerWidth || document.documentElement.clientWidth) + offset;
    }

    function bindEvent(ele, type, fn) {
        if (ele.attachEvent) {
            ele.attachEvent && ele.attachEvent('on' + type, fn);
        } else {
            ele.addEventListener(type, fn, { capture: false, passive: true });
        }
    }

    function unbindEvent(ele, type, fn) {
        if (ele.detachEvent) {
            ele.detachEvent && ele.detachEvent('on' + type, fn);
        } else {
            ele.removeEventListener(type, fn, { capture: false, passive: true });
        }
    }

    function each(object, fn) {
        if (object && fn) {
            var l = object.length;
            for (var i = 0; i < l && fn(object[i], i) !== false; i++) {}
        }
    }

    function throttle(fn, minDelay, scope) {
        var lastCall = 0;
        return function() {
            var now = +new Date();
            if (now - lastCall < minDelay) {
                return;
            }
            lastCall = now;
            fn.apply(scope, arguments);
        };
    }
});


/***/ }),
/* 6 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_js__ = __webpack_require__(0);


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
 * @param query
 */
function getListings() {
    var onDone = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : $.noop;
    var onFail = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : $.noop;
    var query = arguments[2];

    query = query || 'limit=' + gConfig.limit + '&' + cleanQuery(gSearchParams.toString());
    $.ajax({
        type: 'GET',
        url: gConfig.simplyRetsApiUrl + ('?' + query),
        dataType: 'json',
        beforeSend: function beforeSend(xhr) {
            xhr.setRequestHeader('Authorization', 'Basic ' + gConfig.simplyRetsBtoa);
        }
    }).done(onDone).fail(onFail);
}

/**
 * Determine listing title
 * @param type
 * @returns {string}
 */
function determineTitle() {
    var type = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';

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
function getNumberOfPages(xhr, pInfo) {
    var pInfo = pInfo || parseXhr(xhr);

    return Math.ceil(pInfo.total / pInfo.limit);
}

/**
 * Clamp offset so that it's valid
 * @param xhr
 * @param offset
 * @param pInfo  pagination info
 * @returns {*}
 */
function clampOffset(xhr, offset, pInfo) {
    var pInfo = pInfo || parseXhr(xhr),
        maxOffset = getNumberOfPages(xhr, pInfo) * pInfo.limit;

    return __WEBPACK_IMPORTED_MODULE_0__utils_js__["a" /* default */].clamp(offset, 0, maxOffset);
}

/**
 * Get the page offset given a page number
 * @param page
 * @param xhr
 */
function getPageOffset(page, xhr) {
    var pInfo = parseXhr(xhr),
        offset = (page - 1) * pInfo.limit;

    return clampOffset(xhr, offset, pInfo);
}

/* harmony default export */ __webpack_exports__["a"] = ({
    getListings: getListings,
    determineTitle: determineTitle,
    parseXhr: parseXhr,
    getNumberOfPages: getNumberOfPages,
    clampOffset: clampOffset,
    getPageOffset: getPageOffset
});

/***/ }),
/* 7 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function () {
    var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    return "\n        <a href=\"/listing-item/" + data.id + "\" id=\"" + data.id + "\" class=\"card\">\n            <div class=\"card-background b-lazy\" data-src=\"" + data.photo + "\">\n                <span class=\"loader\"></span>\n            </div>\n            <div class=\"card-body\">\n                <div class=\"row card-body-row\">\n                    <div class=\"col-7\">\n                        <h4 class=\"card-title text-primary\">" + data.title + "</h4>\n                    </div>\n                    <div class=\"col-5\">\n                        <h4 class=\"card-title\">$" + data.price + "</h4>\n                    </div>\n                </div>\n        \n                <div class=\"row card-body-row\">\n                    <div class=\"col-7 card-col-reverse\">\n                        <p class=\"card-text\">" + data.address + "</p>\n                    </div>\n                    <div class=\"col-5 card-col-reverse\">\n                        <p class=\"card-text\">\n                            <span class=\"card-item-info\">\n                                <strong>" + data.bedrooms + "</strong> bds\n                            </span>    \n                            <span class=\"card-item-info\">\n                                <strong>" + data.bathrooms + "</strong> ba\n                            </span>    \n                            <span class=\"card-item-info\">\n                                <strong>" + data.property + "</strong> sqft\n                            </span>    \n                        </p>\n                    </div>\n                </div>\n        \n            </div>\n        </a>\n    ";
});

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(9);
module.exports = __webpack_require__(13);


/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__bootstrap_js__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__bootstrap_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__bootstrap_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_bootpag_js__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_bootpag_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_bootpag_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_secondary_nav_js__ = __webpack_require__(11);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_secondary_nav_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_secondary_nav_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_filter_bar_js__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_filter_bar_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_filter_bar_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__utils_js__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__simplyrets_js__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__templates_listing_card_js__ = __webpack_require__(7);








var blazy = new Blazy(),
    debouncedResize,
    $pagination = $('#pagination').bootpag({
    total: 0,
    page: 0,
    maxVisible: 3,
    leaps: true,
    firstLastUse: true,
    first: '←',
    last: '→',
    wrapClass: 'pagination',
    activeClass: 'active',
    disabledClass: 'disabled',
    nextClass: 'next',
    prevClass: 'prev',
    lastClass: 'last',
    firstClass: 'first'
}),
    currentListings = [],
    currentXhr,
    lconfig = {
    $container: $('#cardListings')
};

/**
 * Update listings
 * @param listings
 */
function updateListingCards() {
    var listings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

    currentListings = listings;

    var html = '';
    listings.forEach(function (listing) {
        html += Object(__WEBPACK_IMPORTED_MODULE_6__templates_listing_card_js__["a" /* default */])({
            id: listing.mlsId, // change this
            photo: listing.photos[0],
            title: __WEBPACK_IMPORTED_MODULE_5__simplyrets_js__["a" /* default */].determineTitle(listing.property.type),
            price: __WEBPACK_IMPORTED_MODULE_4__utils_js__["a" /* default */].formatNumber(listing.listPrice),
            address: listing.address.full + ', ' + listing.address.city + ', ' + listing.address.state,
            bedrooms: listing.property.bedrooms || '',
            bathrooms: listing.property.bathrooms || '',
            property: __WEBPACK_IMPORTED_MODULE_4__utils_js__["a" /* default */].formatNumber(listing.property.area)
        });
    });

    lconfig.$container.html(html);
    blazy.revalidate();
}

function displayGridView() {}

function displayMapView() {}

function displayListing() {}

/**
 * Resize pagination
 */
function resizePagination() {
    $pagination.bootpag({
        maxVisible: window.innerWidth > 767 ? 5 : 3
    });
}

/**
 * Handle empty data
 */
function handleNoData() {
    $pagination.hide();
}

/**
 * Get listings from Simply RETS
 */
function getListings() {
    var resetPagination = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

    lconfig.$container.addClass('loading');

    __WEBPACK_IMPORTED_MODULE_5__simplyrets_js__["a" /* default */].getListings(function (data, textStatus, xhr) {
        updateListingCards(data);
        lconfig.$container.removeClass('loading');
        currentXhr = xhr;

        if (resetPagination) {
            // Update total number of pages for pagination
            $pagination.bootpag({
                page: 1,
                total: __WEBPACK_IMPORTED_MODULE_5__simplyrets_js__["a" /* default */].getNumberOfPages(currentXhr),
                firstLastUse: true
            });
        }

        // Handle no data and when there is data, show the pagination
        data.length < 1 ? handleNoData() : $pagination.show();
    }, function (xhr, textStatus, errorThrown) {
        currentXhr = xhr;
        handleNoData();
        console.error(errorThrown);
    });
}

/* MAIN
   ================================================== */

debouncedResize = __WEBPACK_IMPORTED_MODULE_4__utils_js__["a" /* default */].debounce(function () {
    resizePagination();
}, 100);

// Pagination event handler
$pagination.on('page', function (event, page) {
    // Set new offset
    gSearchParams.set('offset', __WEBPACK_IMPORTED_MODULE_5__simplyrets_js__["a" /* default */].getPageOffset(page, currentXhr));
    history.pushState(null, null, '?' + gSearchParams.toString());

    // Scroll to top on pagination change
    $(window).scrollTop($('#secondaryNav').offset().top);

    getListings();
});

// Event listener
$.subscribe('snavbar.change filter.change', function () {
    // Set offset back to 0
    gSearchParams.set('offset', __WEBPACK_IMPORTED_MODULE_5__simplyrets_js__["a" /* default */].getPageOffset(0, currentXhr));
    history.pushState(null, null, '?' + gSearchParams.toString());

    getListings(true);
});

$(window).on('resize', debouncedResize);

getListings(true);
resizePagination();

/***/ }),
/* 10 */
/***/ (function(module, exports) {

/**
 * @preserve
 * bootpag - jQuery plugin for dynamic pagination
 *
 * Copyright (c) 2015 botmonster@7items.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://botmonster.com/jquery-bootpag/
 *
 * Version:  1.0.7
 *
 */
(function ($, window) {

    $.fn.bootpag = function (options) {

        var $owner = this,
            settings = $.extend({
            total: 0,
            page: 1,
            maxVisible: null,
            leaps: true,
            href: 'javascript:void(0);',
            hrefVariable: '{{number}}',
            next: '&raquo;',
            prev: '&laquo;',
            firstLastUse: false,
            first: '<span aria-hidden="true">&larr;</span>',
            last: '<span aria-hidden="true">&rarr;</span>',
            wrapClass: 'pagination',
            activeClass: 'active',
            disabledClass: 'disabled',
            nextClass: 'next',
            prevClass: 'prev',
            lastClass: 'last',
            firstClass: 'first'
        }, $owner.data('settings') || {}, options || {});

        if (settings.total <= 0) return this;

        if (!$.isNumeric(settings.maxVisible) && !settings.maxVisible) {
            settings.maxVisible = parseInt(settings.total, 10);
        }

        $owner.data('settings', settings);

        function renderPage($bootpag, page) {

            page = parseInt(page, 10);
            var lp,
                maxV = settings.maxVisible == 0 ? 1 : settings.maxVisible,
                step = settings.maxVisible == 1 ? 0 : 1,
                vis = Math.floor((page - 1) / maxV) * maxV,
                $page = $bootpag.find('li');
            settings.page = page = page < 0 ? 0 : page > settings.total ? settings.total : page;
            $page.removeClass(settings.activeClass);
            lp = page - 1 < 1 ? 1 : settings.leaps && page - 1 >= settings.maxVisible ? Math.floor((page - 1) / maxV) * maxV : page - 1;

            if (settings.firstLastUse) {
                $page.first().toggleClass(settings.disabledClass, page === 1);
            }

            var lfirst = $page.first();
            if (settings.firstLastUse) {
                lfirst = lfirst.next();
            }

            lfirst.toggleClass(settings.disabledClass, page === 1).attr('data-lp', lp).find('a').attr('href', href(lp));

            var step = settings.maxVisible == 1 ? 0 : 1;

            lp = page + 1 > settings.total ? settings.total : settings.leaps && page + 1 < settings.total - settings.maxVisible ? vis + settings.maxVisible + step : page + 1;

            var llast = $page.last();
            if (settings.firstLastUse) {
                llast = llast.prev();
            }

            llast.toggleClass(settings.disabledClass, page === settings.total).attr('data-lp', lp).find('a').attr('href', href(lp));

            $page.last().toggleClass(settings.disabledClass, page === settings.total);

            var $currPage = $page.filter('[data-lp=' + page + ']');

            var clist = "." + [settings.nextClass, settings.prevClass, settings.firstClass, settings.lastClass].join(",.");
            if (!$currPage.not(clist).length) {
                var d = page <= vis ? -settings.maxVisible : 0;
                $page.not(clist).each(function (index) {
                    lp = index + 1 + vis + d;
                    $(this).attr('data-lp', lp).toggle(lp <= settings.total).find('a').html(lp).attr('href', href(lp));
                });
                $currPage = $page.filter('[data-lp=' + page + ']');
            }
            $currPage.not(clist).addClass(settings.activeClass);
            $owner.data('settings', settings);
        }

        function href(c) {
            return settings.href.replace(settings.hrefVariable, c);
        }

        return this.each(function () {

            var $bootpag,
                lp,
                me = $(this),
                p = ['<ul class="', settings.wrapClass, ' bootpag">'];

            if (settings.firstLastUse) {
                p = p.concat(['<li data-lp="1" class="', settings.firstClass, '"><a href="', href(1), '">', settings.first, '</a></li>']);
            }
            if (settings.prev) {
                p = p.concat(['<li data-lp="1" class="', settings.prevClass, '"><a href="', href(1), '">', settings.prev, '</a></li>']);
            }
            for (var c = 1; c <= Math.min(settings.total, settings.maxVisible); c++) {
                p = p.concat(['<li data-lp="', c, '"><a href="', href(c), '">', c, '</a></li>']);
            }
            if (settings.next) {
                lp = settings.leaps && settings.total > settings.maxVisible ? Math.min(settings.maxVisible + 1, settings.total) : 2;
                p = p.concat(['<li data-lp="', lp, '" class="', settings.nextClass, '"><a href="', href(lp), '">', settings.next, '</a></li>']);
            }
            if (settings.firstLastUse) {
                p = p.concat(['<li data-lp="', settings.total, '" class="last"><a href="', href(settings.total), '">', settings.last, '</a></li>']);
            }
            p.push('</ul>');
            me.find('ul.bootpag').remove();
            me.append(p.join(''));
            $bootpag = me.find('ul.bootpag');

            me.find('li').click(function paginationClick() {

                var me = $(this);
                if (me.hasClass(settings.disabledClass) || me.hasClass(settings.activeClass)) {
                    return;
                }
                var page = parseInt(me.attr('data-lp'), 10);
                $owner.find('ul.bootpag').each(function () {
                    renderPage($(this), page);
                });

                $owner.trigger('page', page);
            });
            renderPage($bootpag, settings.page);
        });
    };
})(jQuery, window);

/***/ }),
/* 11 */
/***/ (function(module, exports) {

var $checkboxes = $('#listingType1, #listingType2, #listingType3, #listingType4'),
    $search = $('#secondarySearch');

$('#secondarySearchForm').on('submit', function (event) {
    event.preventDefault();
    $search.val() ? gSearchParams.set('q', $search.val()) : gSearchParams.delete('q');

    history.pushState(null, null, '?' + gSearchParams.toString());
    $.publish('snavbar.change');
});

$checkboxes.on('change', function () {
    gSearchParams.delete('type[]');

    $checkboxes.each(function () {
        if (this.checked) {
            gSearchParams.append('type[]', this.value);
        }
    });

    history.pushState(null, null, '?' + gSearchParams.toString());
    $.publish('snavbar.change');
});

/***/ }),
/* 12 */
/***/ (function(module, exports) {

// Cache values so that we don't query DOM more than needed
var $bdrmFilters = $('#filterBdrms > .dropdown-item');
var $bathFilters = $('#filterbaths > .dropdown-item');
var $homeTypeFilters = $('#filterHomeType > .dropdown-item');
var $minPriceFilters = $('#filterMinPrice > .dropdown-item');
var $maxPriceFilters = $('#filterMaxPrice > .dropdown-item');
var $minAreaFilters = $('#filterMinArea > .dropdown-item');
var $maxAreaFilters = $('#filterMaxArea > .dropdown-item');

$bdrmFilters.on('click', function (event) {
	var $this = $(this);
	event.preventDefault();

	$bdrmFilters.removeClass('active');

	$this.addClass('active');

	gSearchParams.set('minbeds', $this.data('value'));

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

$bathFilters.on('click', function (event) {
	var $this = $(this);
	event.preventDefault();

	$bathFilters.removeClass('active');

	$this.addClass('active');

	gSearchParams.set('minbaths', $this.data('value'));

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

$homeTypeFilters.on('click', function (event) {
	var $this = $(this);
	event.preventDefault();

	$homeTypeFilters.removeClass('active');

	$this.addClass('active');

	gSearchParams.set('subtype', $this.data('value'));

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

$minPriceFilters.on('change', function () {
	var $this = $(this);
	event.preventDefault();

	$minPriceFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('minprice', $this.val()) : gSearchParams.delete('minprice');

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

$maxPriceFilters.on('change', function () {
	var $this = $(this);
	event.preventDefault();

	$maxPriceFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('maxprice', $this.val()) : gSearchParams.delete('maxprice');

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

$minAreaFilters.on('change', function () {
	var $this = $(this);
	event.preventDefault();

	$minAreaFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('minarea', $this.val()) : gSearchParams.delete('minarea');

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

$maxAreaFilters.on('change', function () {
	var $this = $(this);
	event.preventDefault();

	$maxAreaFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('maxarea', $this.val()) : gSearchParams.delete('maxarea');

	history.pushState(null, null, '?' + gSearchParams.toString());

	$.publish('filter.change');
});

/***/ }),
/* 13 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);