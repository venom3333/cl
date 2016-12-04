<?php
// 1. Общие настройки
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

// 2. Константы
define( 'WWW', dirname( __FILE__ ) );
define( 'APP', dirname( __DIR__ )  );
define( 'CONFIG', dirname( __DIR__ ) . '/config/config.php' );
define( 'CORE', dirname( __DIR__ ) . '/core/core.php' );

// 2. Подключение файлов
require_once CONFIG; // Инициализация настроек
require_once CORE;   // Подключение компонентов фреймворка (PDO, роутер...)

// 3. Запуск роутера (а в нем и шаблонизатора)
$router = new Router;
$router->run();