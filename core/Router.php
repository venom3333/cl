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
	 * @var string, строка алиасов по умолчанию
	 */
	protected $alias = null;


	/**
	 * Router constructor.
	 *
	 */
	function __construct() {

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

				if ( isset( $route['alias'] ) ) {
					$this->alias = $route['alias'];
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

		$this->loadPage();
	}

	/**
	 * Формирование запрашиваемой страницы
	 *
	 * @param string $function название функции вида '$controllerName::$actionName', напр: 'OldIndexController::indexAction'
	 *
	 * @internal param string $controllerName назване контроллера
	 * @internal param string $actionName название функции обработки страницы
	 * @internal param string $params опциональные параметры
	 */
	function loadPage() {

		if ( ! method_exists( $this->controllerName, $this->actionName ) ) {
			Error::e404( "Не найден метод: $this->controllerName" . '->' . $this->actionName );
		}
		$controller = $this->controllerName;
		$action     = $this->actionName;

		$controllerObject = new $controller( $this->route );

		if ( isset( $this->alias ) ) {
			$controllerObject->$action( $this->alias, $this->params );
		} else {
			$controllerObject->$action( $this->params );
		}

		if (LOGGING) {
			$log = Logger::getInstance();
			$log->log("Загружаем $this->controllerName -> $this->actionName");
		}

		$controllerObject->getView();
	}

	/**
	 * проверяет на совпадение таблицу маршрутов и присваивает $route если есть
	 *
	 * @param string $query строка запроса браузера
	 */
	public function dispatch( $query ) {
		$query = $this->removeQueryString( $query );
		if ( $this->matchRoute( $query ) ) {
			// определяем с каким контроллером будем работать
			if ( $this->controllerName == DEFAULT_CONTROLLER ) { // если конкретно в маршруте не указан, т.е. значение по умолчанию
				if ( isset( $this->matches['controller'] ) ) {   // проверяем массив созданный функцией preg_match() в ф-ции matchRoute()
					if ( $this->matches['controller'] ) {        // и если там что-то есть... =>
						$this->controllerName = $this->upperCamelCase( $this->matches['controller'] );
					}
				}
			}
			$this->route['controller'] = $this->controllerName;

			// определяем с каким экшеном будем работать
			if ( $this->actionName == DEFAULT_ACTION ) {        // аналогично, см. выше
				if ( isset( $this->matches['action'] ) ) {
					if ( $this->matches['action'] ) {
						$this->actionName = $this->lowerCamelCase( $this->matches['action'] );
					}
				}
			}
			$this->route['action'] = $this->actionName;

			// определяем есть ли дополнительные параметры
			if ( $this->params == null ) {                      // аналогично, см. выше
				if ( isset( $this->matches['params'] ) ) {
					if ( $this->matches['params'] ) {
						$this->params = $this->matches['params'];
					}
				}
			}
			$this->route['params'] = $this->params;

			// определяем есть ли передан ли алиас
			if ( $this->alias == null ) {                      // аналогично, см. выше
				if ( isset( $this->matches['alias'] ) ) {
					if ( $this->matches['alias'] ) {
						$this->alias = $this->matches['alias'];
					}
				}
			}
			$this->route['alias'] = $this->alias;
		} else {
			Error::e404( 'Даже регулярка не совпала!' );
		}

		$this->controllerName = CONTROLLERS . $this->controllerName . 'Controller';
		$this->actionName     = $this->actionName . 'Action';
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

	protected function removeQueryString( $query ) {
		if ( $query ) {
			$params = explode( '&', $query, 2 );
			if ( ! strpos( $params[0], '=' ) ) {
				return rtrim( $params['0'], '/' );
			} else {
				return '';
			}
		}

		return '';
	}
}

