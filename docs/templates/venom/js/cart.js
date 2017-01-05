function addToCart() {
    var itemClass = this.className;
    itemClass = itemClass.replace("cart-button ", "");

    var data = {};
    data.id = document.getElementById('productId').innerHTML;
    data.name = document.getElementById('productName').innerHTML;
    data.icon = document.getElementById('productIcon').innerHTML;
    data.diameter = document.getElementById(itemClass + 'Diameter').innerHTML;
    data.length = document.getElementById(itemClass + 'Length').innerHTML;
    data.width = document.getElementById(itemClass + 'Width').innerHTML;
    data.height = document.getElementById(itemClass + 'Height').innerHTML;
    data.power = document.getElementById(itemClass + 'Power').innerHTML;
    data.light_output = document.getElementById(itemClass + 'LightOutput').innerHTML;
    data.price = document.getElementById(itemClass + 'Price').innerHTML;
    data.quantity = document.getElementById(itemClass + 'Quantity').value;

    // Ajax запрос
    var url = "/cart/add";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('carticon').innerHTML = xhr.responseText; // обновляем виджет корзины
        }
    };
    xhr.send("data=" + JSON.stringify(data));

    updateWidget();
}

function deleteFromCart() {

    var itemClass = this.className;
    itemClass = itemClass.replace("cart-delete-button ", "");

    var data = {};
    data.id = document.getElementById(itemClass + 'productId').innerHTML;
    data.diameter = document.getElementById(itemClass + 'Diameter').innerHTML;
    data.length = document.getElementById(itemClass + 'Length').innerHTML;
    data.width = document.getElementById(itemClass + 'Width').innerHTML;
    data.height = document.getElementById(itemClass + 'Height').innerHTML;
    data.power = document.getElementById(itemClass + 'Power').innerHTML;
    data.light_output = document.getElementById(itemClass + 'LightOutput').innerHTML;

    var url = "/cart/delete/"
        + data.id
        + data.diameter
        + data.length
        + data.width
        + data.height
        + data.power
        + data.light_output;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText; // Перезагружаем корзину
        }
    };
    xhr.send();

    // И не забудем обновить виджет корзины
    updateWidget();
}

function wipeCart() {
    var url = "/cart/wipe";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText; // Перезагружаем корзину
        }
    };
    xhr.send();

    // И не забудем обновить виджет корзины
    updateWidget();
}

function updateWidget() {
    var url = "/cart/update-widget";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('carticon').innerHTML = xhr.responseText; // обновляем виджет корзины
            setTimeout(addCartListeners, 200); // Добавляем события на кнопки
        }
    };
    xhr.send();

}

function updateProductQuantity() {

    var itemClass = this.className;
    itemClass = itemClass.replace("cart-update-button ", "");

    var data = {};
    data.id = document.getElementById(itemClass + 'productId').innerHTML;
    data.diameter = document.getElementById(itemClass + 'Diameter').innerHTML;
    data.length = document.getElementById(itemClass + 'Length').innerHTML;
    data.width = document.getElementById(itemClass + 'Width').innerHTML;
    data.height = document.getElementById(itemClass + 'Height').innerHTML;
    data.power = document.getElementById(itemClass + 'Power').innerHTML;
    data.light_output = document.getElementById(itemClass + 'LightOutput').innerHTML;

    data.quantity = document.getElementById(itemClass + 'Quantity').value;

    var url = "/cart/update-quantity/"
        + data.id
        + data.diameter
        + data.length
        + data.width
        + data.height
        + data.power
        + data.light_output
        + "/"
        + data.quantity;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            document.getElementById('content').innerHTML = xhr.responseText; // Перезагружаем корзину
        }
    };
    xhr.send();

    // И не забудем обновить виджет корзины
    updateWidget();
}

function addCartListeners() {
    addEventListenerByClass('cart-button', 'click', addToCart);
    addEventListenerByClass('cart-delete-button', 'click', deleteFromCart);
    addEventListenerByClass('cart-update-button', 'change', updateProductQuantity);
    addEventListenerByClass('cart-wipe-button', 'click', wipeCart);
}

addCartListeners();