// Функция для предпросмотра загружаемых изображений
function previewImage(sourceId, destId) {

    var preview = document.getElementById(destId);
    var file = document.getElementById(sourceId).files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}