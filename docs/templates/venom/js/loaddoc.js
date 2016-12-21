// подгруз аджаксом на чистом JS
function loadDoc(id, url) {
    var xmlhttp;
    if (window.XMLHttpRequest) {// код для IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// код для IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById(id).innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    return this;
}

// подгруз аджаксом на JQuery с эффектом затухания
function fadeLoad(id, url) {
    $('#'+id).fadeTo(200,0);

    setTimeout(function () {
        $('#'+id).load(url);
    }, 200);

    setTimeout(function () {
        $('#'+id).fadeTo(200,1);
    }, 350);
}