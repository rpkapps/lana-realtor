import utils from '../utils';

// Cache values so that we don't query DOM more than needed
var $bdrmFilters = $('#filterBdrms > .dropdown-item'),
    $bathFilters = $('#filterbaths > .dropdown-item'),
    $propertySubTypeFilters = $('#filterPropertySubType .custom-control-input'),
    $minPriceFilters = $('#filterMinPrice'),
    $maxPriceFilters = $('#filterMaxPrice'),
    $minAreaFilters = $('#filterMinArea > .form-control'),
    $maxAreaFilters = $('#filterMaxArea > .form-control'),
    $stayOpenDropdowns = $('#filter-bar .dropdown-menu.stay-open'),
    $inputsWithMax = $('#filter-bar input[data-max]');

/**
 * Set additional info for respective tab button
 * @param $element: element that's inside of a dropdown
 * @param value
 */
function setTabAdditionalInfo($element, value) {
    $element.closest('.dropdown-menu').prev().children('.additional-info').text(value);
}

/**
 * Replace text for respective tab button
 * @param $element: element that's inside of a dropdown
 * @param value
 */
function replaceTabText($element, value) {
    var $tab = $element.closest('.dropdown-menu').prev();
    $tab.text(value || $tab.data('default'));
}


/**
 * Update url query parameter
 * @param key
 * @param value
 * @param holdOffPublish
 */
function updateQueryParam(key, value, holdOffPublish) {
    value ? gSearchParams.set(key, value) : gSearchParams.delete(key);

    history.pushState(null, null, `?${gSearchParams.toString()}`);

    if(!holdOffPublish) {
        $.publish('filter.change');
    }
}

/**
 * Update url query parameter that is an array
 * @param key
 * @param values
 */
function updateQueryParamArray(key, values = []) {
    gSearchParams.delete(`${key}[]`);

    values.forEach(function(value) {
        gSearchParams.append(`${key}[]`, value);
    });

    history.pushState(null, null, `?${gSearchParams.toString()}`);

    $.publish('filter.change');
}

/**
 * Update min max inputs/selects
 * @param $min
 * @param $max
 * @param minKey
 * @param maxKey
 * @param updateTabFunc
 */
function minMaxUpdate($min, $max, minKey, maxKey, updateTabFunc) {
    var minVal = parseInt($min.val()),
        maxVal = parseInt($max.val());

    if(minVal && maxVal && minVal > maxVal) {
        $min.val(maxVal);
        $max.val(minVal);
    }

    updateTabFunc();
    updateQueryParam(minKey, $min.val(), true);
    updateQueryParam(maxKey, $max.val());
}

/**
 * Update price tab
 */
function updatePriceTab() {
    var minVal = parseInt($minPriceFilters.val()),
        maxVal = parseInt($maxPriceFilters.val()),
        minText = $minPriceFilters.children('option:selected').text(),
        maxText = $maxPriceFilters.children('option:selected').text();

    if(!minVal && !maxVal) {
        // here it doesn't matter which element we pass ($min or $max)
        return replaceTabText($minPriceFilters);
    }

    if(!minVal) {
        return replaceTabText($minPriceFilters, `$0 - ${maxText}`);
    }

    if(!maxVal) {
        return replaceTabText($minPriceFilters, `${minText}+`);
    }

    replaceTabText($minPriceFilters, `${minText} - ${maxText}`);
}

/**
 * Update price min max select lists
 */
function updatePrice(event) {
    event.preventDefault();
    minMaxUpdate($minPriceFilters, $maxPriceFilters, 'minprice', 'maxprice', updatePriceTab);
}

/**
 * Update area tab
 */
function updateAreaTab() {
    var minVal = parseInt($minAreaFilters.val()),
        maxVal = parseInt($maxAreaFilters.val());

    if(!minVal && !maxVal) {
        // here it doesn't matter which element we pass ($min or $max)
        return replaceTabText($minAreaFilters);
    }

    if(!minVal) {
        return replaceTabText($minAreaFilters, `0 - ${utils.numberWithCommas(maxVal)} (sqft)`);
    }

    if(!maxVal) {
        return replaceTabText($minAreaFilters, `${utils.numberWithCommas(minVal)}+ (sqft)`);
    }

    replaceTabText($minAreaFilters, `${utils.numberWithCommas(minVal)} - ${utils.numberWithCommas(maxVal)} (sqft)`);
}

/**
 * Update area inputs
 */
function updateArea() {
    event.preventDefault();
    minMaxUpdate($minAreaFilters, $maxAreaFilters, 'minarea', 'maxarea', updateAreaTab);
}

$bdrmFilters.on('click', function(event) {
    var $this = $(this),
        value = $this.data('value');
    event.preventDefault();

    $bdrmFilters.removeClass('active');

    $this.addClass('active');

    setTabAdditionalInfo($this, value ? `${value}+ ` : '');

    updateQueryParam('minbeds', value);
});

$bathFilters.on('click', function(event) {
    var $this = $(this),
        value = $this.data('value');
    event.preventDefault();

    $bathFilters.removeClass('active');

    $this.addClass('active');

    setTabAdditionalInfo($this, value ? `${value}+ ` : '');

    updateQueryParam('minbaths', value);
});

$propertySubTypeFilters.on('change', function() {
    var checkedValues = $propertySubTypeFilters.filter(':checked').toArray().map(function(checkbox) {
        return checkbox.value;
    });

    setTabAdditionalInfo($(this), checkedValues.length ? ` (${checkedValues.length})` : '');

    updateQueryParamArray('subtype', checkedValues);
});

$minPriceFilters.on('change', updatePrice);
$maxPriceFilters.on('change', updatePrice);

$minAreaFilters.on('change', updateArea);
$maxAreaFilters.on('change', updateArea);

$stayOpenDropdowns.on('click', function(event) {
    // Keep the dropdown open when clicked inside
    event.stopPropagation();
});

$inputsWithMax.on('keyup change', function(event) {
   var $this = $(this),
       value = $this.val() || '',
       max = parseInt($this.data('max'));

   if(value.length > max) {
       $this.val(value.substring(0, max));
   }
});