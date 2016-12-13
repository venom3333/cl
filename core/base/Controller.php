<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 05.12.2016
 * Time: 11:56
 */

namespace core\base;

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

	public function __construct( $route ) {
		$this->route = $route;
		$this->view  = $route['action'];
	}

	public function getView() {
		$vObj = new View( $this->route, $this->layout, $this->view );
		$vObj->render($this->vars);
	}

	public function set( $vars ) {
		$this->vars = $vars;
	}
}