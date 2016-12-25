<?php
/**
 * Файл настроек
 */

//> Константы для обращения к контроллерам
define( 'PathPrefix', '../controllers/' );
define( 'PathPostfix', 'Controller.php' );

// Умолчания
define( 'CONTROLLERS', 'app\controllers\\' );
define( 'DEFAULT_CONTROLLER', 'Main' );
define( 'DEFAULT_ACTION', 'index' );
//<

//> Используемый шаблон
define( 'TEMPLATE', 'venom' );
define( 'LAYOUT', 'default' );

// пути к файлам шаблонов
define( 'TemplatePrefix', APP . "/views/" . TEMPLATE );
define( 'TemplatePostfix', ".php" );

// пути к файлам шаблонов в вебпространстве
define( 'TemplateWebPath', "/templates/" . TEMPLATE );
//<

// Размеры изображений на сервере
define( 'ICON_WIDTH', 200 );
define( 'ICON_HEIGHT', 150 );
define( 'IMAGE_WIDTH', 1024 );
define( 'IMAGE_HEIGHT', 768 );


// Инициализация корзины
include 'cart.php';