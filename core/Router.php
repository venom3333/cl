<?php
// TODO доработать роутер для ЧПУ и вообще
/**
 * Class Router маршрутизатор
 */
class Router {

	function __construct() {

	}

	/**
	 *  Запуск роутера
	 */
	public function run() {


		// определяем с каким контроллером будем работать
		$controllerName = isset( $_GET['controller'] ) ? ucfirst( $_GET['controller'] ) : 'Index';

		// определяем с каким экшеном будем работать
		$actionName = isset( $_GET['action'] ) ? $_GET['action'] : 'index';

		$smarty = getSmarty(); // запуск и конфигурация шаблонизатора Smarty

		self::loadPage( $smarty, $controllerName, $actionName );
	}

	/**
	 * Формирование запрашиваемой страницы
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param string $controllerName назване контроллера
	 * @param string $actionName название функции обработки страницы
	 */
	function loadPage( Smarty $smarty, $controllerName = 'Index', $actionName = 'index' ) {
		include_once PathPrefix . $controllerName . PathPostfix;

		$actionName .= 'Action';

		$function = $controllerName . 'Controller::' . $actionName;

		$function( $smarty );
	}
}