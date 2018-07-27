$('body').on('click', '[data-toggle="btn-tab"]', function() {
    var $btn = $(this),
        $btnTarget = $($btn.data('target')),
        $btnsInGroup = $btn.parent().children('[data-toggle="btn-tab"]');

    if($btn.hasClass('active')) {
        return;
    }

    $btn.addClass('active');
    $btnTarget.addClass('active');

    // toggle off all other buttons and their respective content
    $btnsInGroup.not(this).each(function() {
        var $this = $(this),
            $target = $($this.data('target'));

        $this.removeClass('active');
        $target.removeClass('active');
    });

    $.publish('btn-tabs.change', [this]);
});