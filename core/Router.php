<?php
namespace core;
/**
 * Class Router маршрутизатор
 */
class Router {

	/**
	 * @var array, таблица маршрутов
	 */
	protected $routes = [];
	/**
	 * @var array, текущий маршрут
	 */
	protected $route = [];
	/**
	 * @var string, строка запроса браузера
	 */
	protected $query;
	/**
	 * @var array, массив найденного маршрута с параметрами
	 */
	protected $matches = [];

	// умолчания
	/**
	 * @var string, имя контроллера по умолчанию
	 */
	protected $controllerName = DEFAULT_CONTROLLER;
	/**
	 * @var string, имя метода (экшена) по умолчанию
	 */
	protected $actionName = DEFAULT_ACTION;
	/**
	 * @var string, строка параметров по умолчанию
	 */
	protected $params = null;
	/**
	 * @var  string, название функции вида '$controllerName::$actionName'
	 */
	protected $function = null; //
	/**
	 * @var \Smarty, объект шаблонизатора
	 */
	protected $smarty = \Smarty::class;

	/**
	 * Router constructor.
	 *
	 * @param $smarty
	 */
	function __construct( $smarty ) {
		$this->smarty = $smarty; // присваиваем объект шаблонизатора

		$this->query = rtrim( $_SERVER['QUERY_STRING'], '/' );  // считываем строку запроса
		require APP . "/config/routes.php";                         // при создании добавляем маршруты
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

				//< Если в маршруте присвоены конкретные значения контроллера и/или экшена и/или параметров
				if ( isset( $route['controller'] ) ) {
					$this->controllerName = $route['controller'];
				}

				if ( isset( $route['action'] ) ) {
					$this->actionName = $route['action'];
				}

				if ( isset( $route['params'] ) ) {
					$this->params = $route['params'];
				}

				//>

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

		$this->loadPage( $this->function );
	}

	/**
	 * Формирование запрашиваемой страницы
	 *
	 * @param string $function название функции вида '$controllerName::$actionName', напр: 'IndexController::indexAction'
	 *
	 * @internal param \Smarty $smarty шаблонизатор
	 * @internal param string $controllerName назване контроллера
	 * @internal param string $actionName название функции обработки страницы
	 * @internal param string $params опциональные параметры
	 */
	function loadPage( $function ) {

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
	 */
	public function dispatch( $query ) {
		if ( $this->matchRoute( $query ) ) {
			// определяем с каким контроллером будем работать
			if ( $this->controllerName == DEFAULT_CONTROLLER ) { // если конкретно в маршруте не указан, т.е. значение по умолчанию
				if ( isset( $this->matches['controller'] ) ) {   // проверяем массив созданный функцией preg_match() в ф-ции matchRoute()
					if ( $this->matches['controller'] ) {        // и если там что-то есть... =>
						$this->controllerName = $this->upperCamelCase( $this->matches['controller'] );
					}
				}
			}
			// определяем с каким экшеном будем работать
			if ( $this->actionName == DEFAULT_ACTION ) {        // аналогично, см. выше
				if ( isset( $this->matches['action'] ) ) {
					if ( $this->matches['action'] ) {
						$this->actionName = $this->lowerCamelCase( $this->matches['action'] );
					}
				}
			}

			// определяем есть ли дополнительные параметры
			if ( isset( $this->matches['params'] ) ) {          // аналогично, см. выше
				if ( $this->matches['params'] ) {
					$this->params = $this->matches['params'];
				}
			}
		} else {
			ErrorController::e404( $this->smarty, 'Даже регулярка не совпала!' );
		}

		$this->controllerName = CONTROLLERS . $this->controllerName . 'Controller';
		$this->actionName     = $this->actionName . 'Action';

		if ( method_exists( $this->controllerName, $this->actionName ) ) {
			$this->function = $this->controllerName . '::' . $this->actionName;
		} else {
			ErrorController::e404( $this->smarty, "Не найден метод: $this->controllerName" . '::' . $this->actionName );
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