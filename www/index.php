<?php
// 1. Общие настройки
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

// 2. Подключение файлов
define( 'ROOT', dirname( __FILE__ ) );
include_once ROOT . '/../config/config.php';            // Инициализация настроек
include_once ROOT . '/../core/ErrorController.php';     // Обработка ошибокinclude_once ROOT . '/../core/ErrorController.php';  // Обработка ошибок
include_once ROOT . '/../core/core.php';                // Подключение компонентов фреймворка (PDO, роутер)
include_once ROOT . '/../library/mainFunctions.php';    // Основные функции

// 3. Запуск роутера
$router = new Router;
$router->run();