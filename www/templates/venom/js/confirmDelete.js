<!--защита от случайного удаления-->
function confirmDelete( deleteRequest ) {
    var answer = confirm("Вы уверены? Это действие нельзя отменить!");
    if (answer) {
        window.location = deleteRequest;
    }
}
<!--защита от случайного удаления-->
