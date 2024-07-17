$(function () {
    $('.cookie_modal').find('[data-action]').click(function (e) {
        e.preventDefault();

        let action = $(this).data('action');

        $.post(action, {cookie: $(this).data('cookie')}, function (data) {
            if (data.cookie) {
                $('.cookie_modal').slideUp('normal', function () {
                    $(this).remove();
                });
            }

            // if (data.gtmHead) {
            //     $('head').prepend(data.gtmHead);
            // }
            //
            // if (data.gtmBody) {
            //     $('body').prepend(data.gtmBody);
            // }
        }, 'json');
    });
});