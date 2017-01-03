<?php

namespace core\base;

use core\Error;

abstract class Controller {
	/**
	 * Текущий маршрут и параметры (controller, action, params, alias)
	 * @var array
	 */
	public $route = [];
	/**
	 * Текущий вид
	 * @var string
	 */
	public $view;
	/**
	 * Текущий шаблон
	 * @var string
	 */
	public $layout;
	/**
	 * Пользовательские данные
	 * @var array
	 */
	public $vars = [];
	/**
	 * Нужна ли админская авторизация
	 * @var bool;
	 */
	private $auth = false;

	/**
	 * Пароль доступа к контроллеру по умолчанию
	 * @var bool;
	 */
	private $pass = ADMIN_PASS;


	/**
	 * Controller constructor.
	 * Создает объект контроллера, проверяет авторизацию и присваивает $route и $view
	 *
	 * @param array $route массив с маршрутом
	 */
	public function __construct( $route ) {
		if ( isset ( $_POST['auth'] ) && md5( $_POST['auth']) === ADMIN_PASS ) {
			$_SESSION ['auth'] = md5( $_POST['auth']);
		}

		if ( $this->auth || $route['action'] !== 'index' ) {
			if ( ! $this->is_auth() ) {
				Error::common( "Идите нахуй. Авторизация не прошла!!!" );
			}
		}
		$this->route = $route;
		$this->view  = $route['action'];
	}

	/**
	 * Проверяет авторизован ли пользователь
	 *
	 * @return bool авторизован или нет
	 */
	private function is_auth() {
		if ( ! isset( $_SESSION ['auth'] ) || $_SESSION ['auth'] != ADMIN_PASS ) {
			return false;
		}

		return true;
	}


	/**
	 *  Получить вид, передать в него параметры и отрисовать
	 */
	public function getView() {
		$viewObject = new View( $this->route, $this->layout, $this->view );
		$viewObject->render( $this->vars );
	}

	/**
	 *  Присвоить пользовательские данные
	 *
	 * @param array $vars
	 */
	public function set( $vars ) {
		$this->vars = $vars;
	}
}