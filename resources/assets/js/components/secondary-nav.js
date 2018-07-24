var $checkboxes = $('#listingType1, #listingType2, #listingType3, #listingType4'),
    $search = $('#secondarySearch');

$('#secondarySearchForm').on('submit', function(event) {
    event.preventDefault();
    $search.val() ? gSearchParams.set('q', $search.val()) : gSearchParams.delete('q');

    history.pushState(null, null, `?${gSearchParams.toString()}`);
    $.publish('snavbar.change');
});

$checkboxes.on('change', function() {
    gSearchParams.delete('type[]');

    $checkboxes.each(function() {
        if(this.checked) {
            gSearchParams.append('type[]', this.value);
        }
    });

    history.pushState(null, null, `?${gSearchParams.toString()}`);
    $.publish('snavbar.change');

    $.publish(`snavbar.type`, [this]);
});

// Sync checkboxes with filter bar
$.subscribe('filter.type', function(event, filter) {
    $checkboxes.filter(`[value="${filter.getAttribute('value')}"]`).prop('checked', filter.checked);
});