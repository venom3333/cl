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


	/**
	 * Controller constructor.
	 * Создает объект контроллера и присваивает $route и $view
	 * @param array $route массив с маршрутом
	 */
	public function __construct( $route ) {
		$this->route = $route;
		$this->view  = $route['action'];
	}


	/**
	 *  Получить вид, передать в него параметры и отрисовать
	 */
	public function getView() {
		$viewObject = new View( $this->route, $this->layout, $this->view );
		$viewObject->render($this->vars);
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