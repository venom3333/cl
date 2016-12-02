<?php

/**
 * Class Router маршрутизатор
 */
class Router {

	protected $routes = [];  // таблица маршрутов
	protected $route = [];   // текущий маршрут
	protected $query;        // строка запроса
	protected $matches = []; // массив найденного маршрута с параметрами

	function __construct() {
		$this->query = rtrim( $_SERVER['QUERY_STRING'], '/' );    // считываем строку запроса
		require "../config/routes.php";             // при создании добавляем маршруты
	}

	/**
	 * Добавляет маршрут
	 *
	 * @param string $regexp строка запроса (регулярка)
	 * @param array $route массив с элементами маршрута (контроллер, экшн, параметры)
	 */
	public function addRoute( $regexp, $route = [] ) {
		$this->routes[ $regexp ] = $route;
	}

	/**
	 * @return array массив всех маршрутов
	 */
	public function getRoutes() {
		return $this->routes;
	}

	/**
	 * @return array массив текущего маршрута
	 */
	public function getRoute() {
		return $this->route;
	}

	/**
	 * Сравнивает есть ли маршруты равные запросу и в случае true присваивает текущему маршруту значение запроса
	 *
	 * @param string $query строка запроса браузера
	 *
	 * @return bool возвращает ответ есть или нет
	 */
	public function matchRoute( $query ) {
		foreach ( $this->routes as $pattern => $route ) {
			if ( preg_match( "#$pattern#i", $query, $this->matches ) ) {
				$this->route = $route;

				return true;
			}
		}

		return false;
	}

	/**
	 * проверяет на совпадение таблицу маршрутов и присваивает $route если есть
	 *
	 * @param string $query строка запроса браузера
	 * @param Smarty $smarty шаблонизатор
	 */
	public function dispatch( Smarty $smarty, $query ) {
		if ( $this->matchRoute( $query ) ) {

		} else {
			echo 'Даже регулярка не совпала!';
			include_once PathPrefix . 'Error' . PathPostfix;
			ErrorController::e404( $smarty );
		}
	}

	/**
	 *  Запуск роутера
	 */
	public function run() {
		// умолчания
		$controllerName = 'Index';
		$actionName     = 'index';
		$params         = 'null';

		$smarty = getSmarty(); // запуск и конфигурация шаблонизатора Smarty

		$this->dispatch( $smarty, $this->query );

		// определяем с каким контроллером будем работать
		if ( isset( $this->matches['controller'] ) ) {
			if ( $this->matches['controller'] ) {
				$controllerName = ucfirst( $this->matches['controller'] );
			}
		}
		// определяем с каким экшеном будем работать
		if ( isset( $this->matches['action'] ) ) {
			if ( $this->matches['action'] ) {
				$actionName = $this->matches['action'];
			}
		}

		// определяем есть ли дополнительные параметры
		if ( isset( $this->matches['params'] ) ) {
			if ( $this->matches['params'] ) {
				$params = $this->matches['params'];
			}
		}

		self::loadPage( $smarty, $controllerName, $actionName, $params );
	}

	/**
	 * Формирование запрашиваемой страницы
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param string $controllerName назване контроллера
	 * @param string $actionName название функции обработки страницы
	 * @param string $params опциональные параметры
	 */
	function loadPage( Smarty $smarty, $controllerName = 'Index', $actionName = 'index', $params = null ) {

		if ( file_exists( PathPrefix . $controllerName . PathPostfix ) ) {  // проверка есть ли файл контроллера
			include_once PathPrefix . $controllerName . PathPostfix;
		} else {
			include_once PathPrefix . 'Error' . PathPostfix;
			ErrorController::e404( $smarty );
		}

		$actionName .= 'Action';

		$function = $controllerName . 'Controller::' . $actionName;

		if ( $params ) {
			$function( $smarty, $params );
		} else {
			$function( $smarty );
		}
	}
}