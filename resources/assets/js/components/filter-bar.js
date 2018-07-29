import utils from '../utils';

// Cache values so that we don't query DOM more than needed
var $filterBar = $('#filterBar'),
    $bdrmFilters = $('#filterBdrms > .dropdown-item'),
    $bathFilters = $('#filterbaths > .dropdown-item'),
    $propertyTypeFilters = $('#filterPropertyType .custom-control-input'),
    $minPriceFilters = $('#filterMinPrice'),
    $maxPriceFilters = $('#filterMaxPrice'),
    $minAreaFilters = $('#filterMinArea > .form-control'),
    $maxAreaFilters = $('#filterMaxArea > .form-control'),
    $stayOpenDropdowns = $('#filterBar .dropdown-menu.stay-open'),
    $inputsWithMax = $('#filterBar input[data-max]');

var filters = [
    {
        key: 'minbeds',
        $elems: $bdrmFilters,
        eventType: 'click',
        update: updateMinDropdown
    },
    {
        key: 'minbaths',
        $elems: $bathFilters,
        eventType: 'click',
        update: updateMinDropdown
    },
    {
        key: 'type[]',
        $elems: $propertyTypeFilters,
        eventType: 'change',
        update: updateCheckboxDropdown
    },
    {
        minKey: 'minprice',
        maxKey: 'maxprice',
        $min: $minPriceFilters,
        $max: $maxPriceFilters,
        $elems: $minPriceFilters.add($maxPriceFilters),
        eventType: 'change',
        updateTabText: updatePriceTab,
        update: updateMinMax
    },
    {
        minKey: 'minarea',
        maxKey: 'maxarea',
        $min: $minAreaFilters,
        $max: $maxAreaFilters,
        $elems: $minAreaFilters.add($maxAreaFilters),
        eventType: 'change',
        updateTabText: updateAreaTab,
        update: updateMinMax
    }
];

// Sync property type filters with the secondary nav checkboxes
$.subscribe('snavbar.type', function(event, checkbox) {
    var $filter = $propertyTypeFilters.filter(`[value="${checkbox.getAttribute('value')}"]`);
    $filter.prop('checked', checkbox.checked);

    // Update the dropdown count that shows the number of checked checkboxes
    filters.forEach(function(filter) {
       if(filter.key === 'type[]') {
           filter.update({
               $current: $filter
           });
       }
    });
});

// Add event handlers to all filters
filters.forEach(function(filter) {
    filter.$elems.on(filter.eventType, function(event) {
        event.preventDefault();
        filter.update({
            $current: $(event.currentTarget)
        });
        $.publish('filter.change');

        // More specific publish
        if(filter.key) {
            $.publish(`filter.${filter.key.replace(/[\[\]']+/g, '')}`, [this]);
        }
    });
});

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
 */
function updateQueryParam(key, value) {
    value ? gSearchParams.set(key, value) : gSearchParams.delete(key);
}

/**
 * Update url query parameter that is an array
 * @param key
 * @param values
 */
function updateQueryParamArray(key, values = []) {
    gSearchParams.delete(`${key}`);

    values.forEach(function(value) {
        gSearchParams.append(`${key}`, value);
    });
}

/**
 * Update min max input/select
 * @param clear
 */
function updateMinMax({clear}) {
    if(clear) {
        this.$min.val('');
        this.$max.val('');
        this.$min.children('option').prop('selected', false);
        this.$max.children('option').prop('selected', false);
    }

    var minVal = parseInt(this.$min.val()),
        maxVal = parseInt(this.$max.val());

    if(minVal && maxVal && minVal > maxVal) {
        this.$min.val(maxVal);
        this.$max.val(minVal);
    }

    this.updateTabText();
    updateQueryParam(this.minKey, this.$min.val());
    updateQueryParam(this.maxKey, this.$max.val());
}

/**
 * Update price tab text
 */
function updatePriceTab() {
    updateTabForMinMax({
        $elem: this.$min,
        minVal: parseInt(this.$min.val()),
        maxVal: parseInt(this.$max.val()),
        minText: this.$min.children('option:selected').text(),
        maxText: this.$max.children('option:selected').text(),
        zeroValue: '$0'
    });
}

/**
 * Update area tab text
 */
function updateAreaTab() {
    updateTabForMinMax({
        $elem: this.$min,
        minVal: parseInt(this.$min.val()),
        maxVal: parseInt(this.$max.val()),
        minText: utils.numberWithCommas(this.$min.val()),
        maxText: utils.numberWithCommas(this.$max.val()),
        textAfter: ' (sqft)'
    });
}

/**
 * Update tab text for min/max dropdown
 * @param $elem: either the $min or $max element
 * @param minVal
 * @param maxVal
 * @param minText
 * @param maxText
 * @param zeroValue: value that should show up when minVal is not set
 * @param textAfter: will be shown after all the text
 */
function updateTabForMinMax({
    $elem, minVal, maxVal, minText = '', maxText = '', zeroValue = '0', textAfter = ''
}) {
    if(!minVal && !maxVal) {
        return replaceTabText($elem);
    }

    if(!minVal) {
        return replaceTabText($elem, `${zeroValue} - ${maxText}${textAfter}`);
    }

    if(!maxVal) {
        return replaceTabText($elem, `${minText}+${textAfter}`);
    }

    replaceTabText($elem, `${minText} - ${maxText}${textAfter}`);
}

/**
 * Update min filters dropdown (the dropdown container that has values such as 1+, 2+, etc.)
 * @param $current: current anchor element
 * @param clear
 */
function updateMinDropdown({$current, clear}) {
    if(clear) {
        $current = this.$elems.first();
    }

    var value = $current.data('value');

    this.$elems.removeClass('active');

    $current.addClass('active');

    setTabAdditionalInfo($current, value ? `${value}+ ` : '');
    updateQueryParam(this.key, value, true);
}

/**
 * Update checkboxes dropdown
 * @param $current: current checkbox element
 * @param clear
 */
function updateCheckboxDropdown({$current, clear}) {
    if(clear) {
        this.$elems.prop('checked', false);
        $current = this.$elems.first();
    }

    var checkedValues = this.$elems.filter(':checked').toArray().map(function(checkbox) {
        return checkbox.value;
    });

    setTabAdditionalInfo($current, checkedValues.length ? ` (${checkedValues.length})` : '');

    updateQueryParamArray(this.key, checkedValues);
}

/**
 * Clear all filters in filter bar
 */
function clearAll() {
    filters.forEach(function(filter) {
        filter.update({
            clear: true
        });
    });

    $.publish('filter.change');
}