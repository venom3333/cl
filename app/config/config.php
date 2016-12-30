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
define( 'DEFAULT_ICON_WIDTH', 350 );
define( 'DEFAULT_ICON_HEIGHT', 263 );
define( 'IMAGE_WIDTH', 1280 );
define( 'IMAGE_HEIGHT', 1024 );
define( 'PROJECT_ICON_WIDTH', 350 );
define( 'PROJECT_ICON_HEIGHT', 263 );

// Емайлы
define( 'SUPER_ADMIN_EMAIL', 'v.kagsfey@mail.ru' );
define( 'ADMIN_EMAIL', 'v.kagsfey@mail.ru' );
define( 'DEFAULT_EMAIL', 'info@customlight.ru' );

// Админ pass
define( 'ADMIN_PASS', 'IamADMIN');


// Инициализация корзины
include 'cart.php';