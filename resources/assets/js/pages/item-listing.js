import '../bootstrap.js';

var $search = $('#secondarySearch');

$('.gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    gallery: {
        enabled: true
    },
});

$('.gallery-icon-link').on('click', function() {
    // open gallery at first image
    $('.gallery a:first-child').trigger('click');
});

$('#secondarySearchForm').on('submit', function(event) {
    event.preventDefault();
    var query = $search.val() ? '?q=' + $search.val() : '';
    window.location.href = '/' + gSearchPage + query;
});