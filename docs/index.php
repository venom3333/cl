<?php
//TODO: Объединить изображения в одну таблицу (добавить в нее поле 'type') (под вопросом...)
//TODO: Нужен ORM (скорее всего ActiveRecord)

// 1. Общие настройки
session_start();

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

// 2. Константы
define( 'WWW', __DIR__ );
define( 'ROOT', dirname( __DIR__ ) );
define( 'APP', dirname( __DIR__ ) . '/app' );
define( 'CONFIG', dirname( __DIR__ ) . '/app/config/config.php' );
define( 'CORE', dirname( __DIR__ ) . '/core/core.php' );
require_once ROOT . "/core/constants.php";

// ЗАГЛУШКА! Если не босс, то временная главная страница
if ( filter_input(INPUT_POST, 'boss' ) && filter_input(INPUT_POST, 'boss', FILTER_SANITIZE_SPECIAL_CHARS) === 'IamTheBOSS' ) {
	$_SESSION ['boss'] = filter_input(INPUT_POST, 'boss', FILTER_SANITIZE_SPECIAL_CHARS);
}
if ( ! isset( $_SESSION ['boss'] ) || $_SESSION ['boss'] != 'IamTheBOSS' ) {
	header( 'Location: placeholder/index.html' );
	exit();
}
// /Если не босс, то временная главная страница

// 2. Подключение файлов
require_once CORE;   // Подключение компонентов фреймворка (PDO, роутер...)
require_once CONFIG; // Инициализация настроек

// 3. Функция автозагрузки классов
// функция автозагрузки файлов классов
spl_autoload_register( function ( $class ) {
        $file = ROOT . '/' . str_replace( '\\', '/', $class ) . '.php';
	if ( file_exists( $file ) ) {
		require_once $file;
	} else {
		echo "Не найден файл Класса: $class.php";
		die;
	}
} );

// 4. Настройка логгирования.
define( 'LOGGING', OFF );

// 5. Запуск роутера
$router = new core\Router();
$router->run();