/*
 * Отправка формы "перезвоните нам"
 * @returns {undefined}
 */
function callbackMail() {
    var data = {};
    data.name = document.getElementById('inputName').value;
    data.number = document.getElementById('inputPhoneNumber').value;
    data.text = document.getElementById('inputText').value;
    
    // валидация
    if (!data.name){
        Notify({status: false, message: 'Вы не указали имя!', timer: 5});
        return;
    }
    if (!data.number){
        Notify({status: false, message: 'Вы не указали номер телефона!', timer: 5});
        return;
    }

    Notify({status: true, def: true, message: 'Идет отправка...', timer: 32});

    // Ajax запрос
    var url = "/mail/callback";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            Notify({status: true, message: 'Ваша заявка принята. Ожидайте звонка менеджера. Спасибо!', timer: 8});
            document.getElementById('callback').reset(); // чистим форму
        } else {
            Notify({status: false, message: 'Упс! Произошла ошибка на сервере. Пожалуйста, позвоните нам!', timer: 16});
        }
    };
    xhr.send("data=" + JSON.stringify(data));

}

/*
 * Отправка формы заказа из корзины
 * @returns {undefined}
 */
function makeOrderMail() {

    var data = {};
    if (document.getElementById('cartDelivery1').checked) {
        data.delivery = document.getElementById('cartDelivery1').value;
    } else {
        data.delivery = document.getElementById('cartDelivery2').value;
    }
    data.name = document.getElementById('cartName').value;
    data.number = document.getElementById('cartPhoneNumber').value;
    data.email = document.getElementById('cartEmail').value;
    data.address = document.getElementById('cartAddress').value;
    data.text = document.getElementById('cartNotes').value;
    
    // валидация
    if (!data.name){
        Notify({status: false, message: 'Вы не указали имя!', timer: 5});
        return;
    }
    if (!data.number){
        Notify({status: false, message: 'Вы не указали номер телефона!', timer: 5});
        return;
    }

    // console.log(data);

    Notify({status: true, def: true, message: 'Идет отправка...', timer: 32});

    // Ajax запрос
    var url = "/mail/make-order";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            Notify({status: true, message: 'Ваша заявка принята. Ожидайте звонка менеджера. Спасибо!', timer: 8});
            document.getElementById('checkout').reset();
            document.getElementById('content').innerHTML = xhr.responseText; // Перезагружаем корзину
        } else {
            Notify({status: false, message: 'Упс! Произошла ошибка на сервере. Пожалуйста, позвоните нам!', timer: 16});
        }
    };
    xhr.send("data=" + JSON.stringify(data));

}

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
                Notify({status: setup.status});
            }, 1000 * timer);
        }
    } else {
        $(box_id).removeClass('show-up');
    }
}
$('.notification-close').click(function () {
    $('.notification-close').parent('div').removeClass('show-up');
});



// Лисенеры
function addMailListeners() {
    addEventListenerByClass('callback-mail-button', 'click', callbackMail);
    addEventListenerByClass('make-order-button', 'click', makeOrderMail);
}

window.onload(addMailListeners());