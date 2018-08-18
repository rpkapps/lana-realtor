import btn from './button';

$('.contact-form').on('submit', function(event) {
    event.preventDefault();

    var $form = $(this),
        $submitBtn = $form.find('.btn[type="submit"]');

    btn.addLoader($submitBtn);

    $.ajax({
        type: 'POST',
        url: '/api/v1/mail',
        data: $form.serialize(),
    }).done(function() {
        btn.removeLoader($submitBtn);
        $form.closest('.modal').modal('hide');

        if($form.next().hasClass('contact-form-success')) {
            $form.hide();
            $form.next().show();
        }
    }).fail(function() {
        btn.removeLoader($submitBtn);
        $form.closest('.modal').modal('hide');
        alert('Failed to send email. Please try again later.');
    });
});