<?php
// 1. Общие настройки
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

// 2. Подключение файлов
define( 'ROOT', dirname( __FILE__ ) );
include_once ROOT . '/../config/config.php';            // Инициализация настроек
include_once ROOT . '/../components/venom/Db.php';      // Подключение к базе данных PDO
include_once ROOT . '/../library/mainFunctions.php';    // Основные функции

// определяем с каким контроллером будем работать
$controllerName = isset( $_GET['controller'] ) ? ucfirst( $_GET['controller'] ) : 'Index';

// определяем с каким экшеном будем работать
$actionName = isset( $_GET['action'] ) ? $_GET['action'] : 'index';

loadPage( $smarty, $controllerName, $actionName );