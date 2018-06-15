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
});

/**
 * Check if all checkboxes are unchecked with secondary nav
 */
function allUnchecked() {
    return $checkboxes.filter(':checked').length < 1;
}

export default {
    allUnchecked: allUnchecked
}