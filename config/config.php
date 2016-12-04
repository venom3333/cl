<?php
/**
 * Файл настроек
 */

//> Константы для обращения к контроллерам
define( 'PathPrefix', '../controllers/' );
define( 'PathPostfix', 'Controller.php' );
//<

//> Используемый шаблон
//$template = 'default';
$template = 'light';

// пути к файлам шаблонов (*.tpl)
define( 'TemplatePrefix', "../views/$template/" );
define( 'TemplatePostfix', ".tpl" );

// пути к файлам шаблонов в вебпространстве
define( 'TemplateWebPath', "/templates/$template/" );
//<

// функция запуска и настроек Smarty
include_once 'smarty.php';