// Cache values so that we don't query DOM more than needed
let $bdrmFilters = $('#filterBdrms > .dropdown-item');
let $bathFilters = $('#filterbaths > .dropdown-item');
let $homeTypeFilters = $('#filterHomeType > .dropdown-item');
let $minPriceFilters = $('#filterMinPrice > .dropdown-item');
let $maxPriceFilters = $('#filterMaxPrice > .dropdown-item');
let $minAreaFilters = $('#filterMinArea > .dropdown-item');
let $maxAreaFilters = $('#filterMaxArea > .dropdown-item');

$bdrmFilters.on('click', function(event) {
	let $this = $(this);
	event.preventDefault();

	$bdrmFilters.removeClass('active');

	$this.addClass('active');

	gSearchParams.set('minbeds', $this.data('value'));

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});

$bathFilters.on('click', function(event) {
	let $this = $(this);
	event.preventDefault();

	$bathFilters.removeClass('active');

	$this.addClass('active');

	gSearchParams.set('minbaths', $this.data('value'));

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});


$homeTypeFilters.on('click', function(event) {
	let $this = $(this);
	event.preventDefault();

	$homeTypeFilters.removeClass('active');

	$this.addClass('active');

	gSearchParams.set('subtype', $this.data('value'));

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});


$minPriceFilters.on('change', function() {
	let $this = $(this);
	event.preventDefault();

	$minPriceFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('minprice', $this.val()) : gSearchParams.delete('minprice');

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});

$maxPriceFilters.on('change', function() {
	let $this = $(this);
	event.preventDefault();

	$maxPriceFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('maxprice', $this.val()) : gSearchParams.delete('maxprice');

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});

$minAreaFilters.on('change', function() {
	let $this = $(this);
	event.preventDefault();

	$minAreaFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('minarea', $this.val()) : gSearchParams.delete('minarea');

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});

$maxAreaFilters.on('change', function() {
	let $this = $(this);
	event.preventDefault();

	$maxAreaFilters.removeClass('active');

	$this.addClass('active');

	$this.val() ? gSearchParams.set('maxarea', $this.val()) : gSearchParams.delete('maxarea');

    history.pushState(null, null, `?${gSearchParams.toString()}`);

	$.publish('filter.change');
});

