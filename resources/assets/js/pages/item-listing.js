import '../bootstrap.js';

var $search = $('#secondarySearch'),
    $mortgageAmount = $('#mortgageAmount'),
    $mortgageDownPayment = $('#mortgageDownPayment'),
    $mortgageLoanTerm = $('#mortgageLoanTerm'),
    $mortgageInterestRate = $('#mortgageInterestRate'),
    $mortgagePayment = $('#mortgagePayment');

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

$('#mortgageCalculator input').on('change', updateMortgageValue);

updateMortgageValue();

function updateMortgageValue(){
    var amount = parseInt($mortgageAmount.val()) * (1 - (parseInt($mortgageDownPayment.val()) / 100)),
        interest = parseInt($mortgageInterestRate.val()) / 1200,
        term = parseInt($mortgageLoanTerm.val()) * 12,
        monthlyPayment;
    
    if(interest == 0){
        monthlyPayment = amount / term;
    } 

    else{   
        monthlyPayment = amount*(interest * Math.pow((1 + interest), term))/(Math.pow((1 + interest), term) - 1);
    }


    monthlyPayment = monthlyPayment.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    $mortgagePayment.text('Monthly Payment $' + monthlyPayment);
}
