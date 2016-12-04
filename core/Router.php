<?php

/**
 * Class Router маршрутизатор
 */
class Router {

	protected $routes = [];  // таблица маршрутов
	protected $route = [];   // текущий маршрут
	protected $query;        // строка запроса
	protected $matches = []; // массив найденного маршрута с параметрами

	// умолчания
	protected $controllerName = 'Index';
	protected $actionName = 'index';
	protected $params = 'null';
	protected $smarty = Smarty::class;  // объект шаблонизатора

	function __construct() {
		$this->smarty = getSmarty(); // запуск и конфигурация шаблонизатора Smarty

		$this->query = rtrim( $_SERVER['QUERY_STRING'], '/' );    // считываем строку запроса
		require "../config/routes.php";             // при создании добавляем маршруты

		// функция автозагрузки файлов классов контроллеров
		spl_autoload_register( function ( $class ) {
			$file = APP . "/controllers/$class.php";
			if ( is_file( $file ) ) {
				require_once $file;
			} else {
				ErrorController::e404( $this->smarty, "Не найден файл Контроллера: $class.php" );
			}
		} );
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
	 *  Запуск роутера
	 */
	public function run() {

		$this->dispatch( $this->query );

		$this->loadPage();
	}

	/**
	 * Формирование запрашиваемой страницы
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param string $controllerName назване контроллера
	 * @param string $actionName название функции обработки страницы
	 * @param string $params опциональные параметры
	 */
	function loadPage() {

		$this->actionName .= 'Action';

		if ( method_exists( $this->controllerName . 'Controller', $this->actionName ) ) {
			$function = $this->controllerName . 'Controller::' . $this->actionName;
		} else {
			ErrorController::e404( $this->smarty, 'Не найден метод: ' . $this->controllerName . 'Controller::' . $this->actionName . '()' );
		}

		if ( $this->params ) {
			$function( $this->smarty, $this->params );
		} else {
			$function( $this->smarty );
		}
	}

	/**
	 * проверяет на совпадение таблицу маршрутов и присваивает $route если есть
	 *
	 * @param string $query строка запроса браузера
	 * @param Smarty $smarty шаблонизатор
	 */
	public function dispatch( $query ) {
		if ( $this->matchRoute( $query ) ) {
			// определяем с каким контроллером будем работать
			if ( isset( $this->matches['controller'] ) ) {
				if ( $this->matches['controller'] ) {
					$this->controllerName = $this->upperCamelCase( $this->matches['controller'] );
				}
			}
			// определяем с каким экшеном будем работать
			if ( isset( $this->matches['action'] ) ) {
				if ( $this->matches['action'] ) {
					$this->actionName = $this->lowerCamelCase( $this->matches['action'] );
				}
			}

			// определяем есть ли дополнительные параметры
			if ( isset( $this->matches['params'] ) ) {
				if ( $this->matches['params'] ) {
					$this->params = $this->matches['params'];
				}
			}
		} else {
			ErrorController::e404( $this->smarty, 'Даже регулярка не совпала!' );
		}
	}

	/**
	 * преобразует строку вида "что-нибудь этакое" в "ЧтоНибудьЭтакое" (в КэмэлКейс)
	 *
	 * @param string $str строка запроса браузера
	 *
	 * @return string
	 */
	protected function upperCamelCase( $str ) {
		$str = str_replace( '-', ' ', $str );
		$str = ucwords( $str );
		$str = str_replace( ' ', '', $str );

		return $str;
	}

	/**
	 * преобразует строку вида "что-нибудь этакое" в "чтоНибудьЭтакое" (в кэмэлКейс)
	 *
	 * @param string $str строка запроса браузера
	 *
	 * @return string
	 */
	protected function lowerCamelCase( $str ) {
		return lcfirst( $this->upperCamelCase( $str ) );
	}
}