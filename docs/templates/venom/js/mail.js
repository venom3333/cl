function callbackMail() {
    var data = {};
    data.name = document.getElementById('inputName').value;
    data.number = document.getElementById('inputPhoneNumber').value;
    data.text = document.getElementById('inputText').value;


    // Ajax запрос
    var url = "/mail/callback";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Ваша заявка отправлена, мы Вам перезвоним как можно скорее!');
            location.reload();
        }
    };
    xhr.send("data=" + JSON.stringify(data));

}

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

    console.log(data);

    // Ajax запрос
    var url = "/mail/make-order";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Ваша заказ отправлен в обработку, мы Вам перезвоним как можно скорее!');
            location.reload();
        }
    };
    xhr.send("data=" + JSON.stringify(data));

}

function addMailListeners() {
    addEventListenerByClass('callback-mail-button', 'click', callbackMail);
    addEventListenerByClass('make-order-button', 'click', makeOrderMail);
}

setTimeout(addMailListeners, 500);