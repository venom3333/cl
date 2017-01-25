function get(name) {
    if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}


$(document).ready(function () {

    /**
     * Отправка всех форм на сервер
     */
    $('form.send_to_crm').submit(function(e){
        e.preventDefault();

        $(":submit").attr("disabled", true);
        
        var $isform = $(this);
        Notify({status: true, def: true, message: 'Идет отправка...', timer: 32});

        $.ajax({
            url: 'mail.php',
            type: 'POST',
            dataType: 'json',
            data: $.param($(this).serializeArray()),
            success: function (res, textStatus, jqXHR) {
                if (res.status) {
                    Notify({status: true, message: 'Ваша заявка принята. Ожидайте звонка менеджера. Спасибо!', timer: 8});
                    $isform.trigger('reset');
                    $.fancybox.close();
                } else {
                    Notify({status: false, message: res.comment, timer: 8});
                }
                $(":submit").removeAttr("disabled");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Notify({status: false, message: 'Упс! Произошла ошибка на сервере. Пожалуйста, позвоните нам!', timer: 16});
                $isform.trigger('reset');
                $.fancybox.close();
                $(":submit").removeAttr("disabled");
            }
        });
        return false;
    });

    /**
     * Всплывающее окно уведомлений
     */
    $('a.ontification-close').click(function () {
        $(this).parent('div').removeClass('show-up');
    });
    var TimeOutNotify = null;
    function Notify(setup) {
        var box_id = setup.status ? '#success-notification' : '#error-notification';
        var def = setup.def || false;
        if (def) box_id = '#default-notification';

        var message = setup.message || null;
        var timer = setup.timer || false;

        if (message !== null) {
            $('#success-notification').removeClass('show-up');
            $('#default-notification').removeClass('show-up');
            $('#error-notification').removeClass('show-up');

            $(box_id).children('p').html(message);
            $(box_id).addClass('show-up');

            if (timer) {
                clearTimeout(TimeOutNotify);
                TimeOutNotify = setTimeout(function () {
                    Notify({status: setup.status})
                }, 1000 * timer);
            }
        } else {
            $(box_id).removeClass('show-up');
        }
    }
    $('#fancybox-close').click(function () {
        $('a.notification-close').parent('div').removeClass('show-up');
        $form.trigger('reset');
    });
});




