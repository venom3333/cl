<?php
/**
 * Файл настроек
 */

//> Константы для обращения к контроллерам
define( 'PathPrefix', '../controllers/' );
define( 'PathPostfix', 'Controller.php' );

// Умолчания
define( 'CONTROLLERS', 'app\controllers\\');
define( 'DEFAULT_CONTROLLER', 'Main');
define( 'DEFAULT_ACTION', 'index');
//<

//> Используемый шаблон
define( 'TEMPLATE', 'venom');
define( 'LAYOUT', 'default');


// пути к файлам шаблонов
define( 'TemplatePrefix', APP . "/views/" . TEMPLATE );
define( 'TemplatePostfix', ".php" );

// пути к файлам шаблонов в вебпространстве
define( 'TemplateWebPath', "/templates/" . TEMPLATE );
//<

// Инициализация корзины
include_once 'cart.php';