<?php
// определяем с каким контроллером будем работать
$controllerName = isset( $_GET['controller'] ) ? ucfirst( $_GET['controller'] ) : 'Index';

echo 'Подключаемый php файл (Контроллер) = ' . $controllerName . '<br>';

// определяем с каким экшеном будем работать
$actionName = isset( $_GET['action'] ) ? $_GET['action'] : 'index';

echo 'Функция, формирующая страницу (Экшен) = ' . $actionName . '<br>';

// подключаем контроллер
include_once '../controllers/' . $controllerName . 'Controller.php';

// формируем название функции
$function = $actionName . 'Action';

echo 'Полное название вызываемой функции = ' . $function . '<br>';

$function();