<?php
// 1. Общие настройки
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

// 2. Константы
define( 'WWW', __DIR__ );
define( 'ROOT', dirname( __DIR__ ) );
define( 'APP', dirname( __DIR__ ) . '/app'  );
define( 'CONFIG', dirname( __DIR__ ) . '/app/config/config.php' );
define( 'CORE', dirname( __DIR__ ) . '/core/core.php' );

// 2. Подключение файлов
require_once CONFIG; // Инициализация настроек
require_once CORE;   // Подключение компонентов фреймворка (PDO, роутер...)

// 3. Смарти шаблонизатор.
$smarty = getSmarty();

// 3. Функция автозагрузки классов
// функция автозагрузки файлов классов
spl_autoload_register( function ( $class ) {

	if ( file_exists( $file = ROOT . '/' . str_replace( '\\', '/', $class) . '.php' ) ) {
		require_once $file;
	}
	else {
		d("Не найден файл Класса: $class.php" );
	}
} );

// 4. Запуск роутера
$router = new core\Router($smarty);
$router->run();