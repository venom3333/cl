<?php

namespace core\base;

use core\Error;

abstract class Controller {
	/**
	 * Текущий маршрут и параметры (controller, action, params, alias)
	 * @var array
	 */
	public $route = array();
	/**
	 * Текущий вид
	 * @var string
	 */
	public $view;
	/**
	 * Текущий шаблон
	 * @var string
	 */
	public $layout = 'default';
	/**
	 * Пользовательские данные
	 * @var array
	 */
	public $vars = [];

	/**
	 * общая информация для определенного шаблона (меню и т.п.)
	 * @var array
	 */
	protected $layoutEssentials = array();

	/**
	 * Нужна ли админская авторизация
	 * @var bool;
	 */
	protected $auth = false;

	/**
	 * Наименование категории авторизации (для разграничения уровней доступа)
	 * @var bool;
	 */
	protected $authCategory = 'auth';

	/**
	 * Пароль доступа к контроллеру по умолчанию
	 * @var string;
	 */
	protected $pass = ADMIN_PASS;

	/**
	 * Получен ли доступ к контроллеру
	 * @var bool;
	 */
	protected $is_auth = false;

	/**
	 * Controller constructor.
	 * Создает объект контроллера, проверяет авторизацию и присваивает $route и $view
	 *
	 * @param array $route массив с маршрутом
	 */
	public function __construct( $route ) {
		//> блок функционала авторизации
		if ( isset ( $_POST[$this->authCategory] ) && md5( $_POST[$this->authCategory] ) === $this->pass ) {
			$_SESSION [$this->authCategory] = md5( $_POST[$this->authCategory] );
		}
		if ( $this->auth && $route['action'] !== 'index' ) { // т.к. индексные страницы, как правило, являются страницами авторизации
			if ( ! $this->is_auth() ) {
				Error::common( "Идите нахуй. Авторизация не прошла!!!" );
			} else {
				$this->is_auth = true;
			}
		}
		//< блок функционала авторизации

		$this->route = $route;
		$this->view  = $route['action'];
		$this->getLayoutEssentials();
	}

	/**
	 * Проверяет авторизован ли пользователь
	 *
	 * @return bool авторизован или нет
	 */
	private function is_auth() {
		if ( ! isset( $_SESSION [$this->authCategory] ) || $_SESSION [$this->authCategory] != $this->pass ) {
			return false;
		}

		return true;
	}

	// Загружает необходимую информацию для определенного шаблона
	protected abstract function getLayoutEssentials();

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