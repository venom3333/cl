<?php
/**
 * Файл настроек
 */

//> Константы для обращения к контроллерам
define( 'PathPrefix', '../controllers/' );
define( 'PathPostfix', 'Controller.php' );

// Умолчания
define( 'CONTROLLERS', 'app\controllers\\');
define( 'DEFAULT_CONTROLLER', 'Index');
define( 'DEFAULT_ACTION', 'index');
//<

//> Используемый шаблон
//$template = 'default';
$template = 'light';

// пути к файлам шаблонов (*.tpl)
define( 'TemplatePrefix', APP . "/views/$template/" );
define( 'TemplatePostfix', ".tpl" );

// пути к файлам шаблонов в вебпространстве
define( 'TemplateWebPath', "/templates/$template/" );
//<

// функция запуска и настроек Smarty
include_once 'smarty.php';