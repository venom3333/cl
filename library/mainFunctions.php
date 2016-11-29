<?php
/**
 * Основные функции
 */

/**
 * Формирование запрашиваемой страницы
 *
 * @param Smarty $smarty шаблонизатор
 * @param string $controllerName назване контроллера
 * @param string $actionName название функции обработки страницы
 */
function loadPage( $smarty, $controllerName, $actionName = 'index' ) {
	include_once PathPrefix . $controllerName . PathPostfix;

	$function = $actionName . 'Action';
	$function( $smarty );
}

/**
 * @param Smarty $smarty объект шаблонизатора
 * @param string $templateName название файла шаблона
 */
function loadTemplate( Smarty $smarty, $templateName ) {
	$smarty->display( $templateName . TemplatePostfix );
}

function d( $value = null, $die = 1 ) {
	echo 'Debug: <br><pre>';
	print_r( $value );
	echo '</pre>';

	if ( $die ) {
		die;
	}
}
