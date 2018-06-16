// Cache values so that we don't query DOM more than needed
var $bdrmFilters = $('#filterBdrms > .dropdown-item'),
    $bathFilters = $('#filterbaths > .dropdown-item'),
    $homeTypeFilters = $('#filterHomeType .custom-control-input'),
    $minPriceFilters = $('#filterMinPrice > .form-control'),
    $maxPriceFilters = $('#filterMaxPrice > .form-control'),
    $minAreaFilters = $('#filterMinArea > .form-control'),
    $maxAreaFilters = $('#filterMaxArea > .form-control');

/**
 * Update url query parameter
 * @param key
 * @param value
 */
function updateQueryParam(key, value) {
    value ? gSearchParams.set(key, value) : gSearchParams.delete(key);

    history.pushState(null, null, `?${gSearchParams.toString()}`);

    $.publish('filter.change');
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
 
$bdrmFilters.on('click', function(event) {
	var $this = $(this);
	event.preventDefault();

	$bdrmFilters.removeClass('active');

	$this.addClass('active');

    updateQueryParam('minbeds', $this.data('value'));
});

$bathFilters.on('click', function(event) {
	var $this = $(this);
	event.preventDefault();

	$bathFilters.removeClass('active');

	$this.addClass('active');

    updateQueryParam('minbaths', $this.data('value'));
});

$homeTypeFilters.on('change', function() {
    var checkedValues = $homeTypeFilters.filter(':checked').toArray().map(function(checkbox) {
        return checkbox.value;
    });

    updateQueryParamArray('subtype', checkedValues);
});

$minPriceFilters.on('change', function() {
	event.preventDefault();
    updateQueryParam('minprice', this.value);
});

$maxPriceFilters.on('change', function() {
	event.preventDefault();
    updateQueryParam('maxprice', this.value);
});

$minAreaFilters.on('change', function() {
    event.preventDefault();
    updateQueryParam('minarea', this.value);
});

$maxAreaFilters.on('change', function() {
	event.preventDefault();
    updateQueryParam('maxarea', this.value);
});