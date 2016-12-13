<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 05.12.2016
 * Time: 13:21
 */

namespace core\base;

class View {
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

	public function __construct( $route, $layout = '', $view = '' ) {
		$this->route = $route;

		if ( $layout === false ) {  // если шаблон явно задан как false
			$this->layout = false;
		} else {
			$this->layout = $layout ?: LAYOUT; // Если пустая строка, то шаблон по умолчанию
		}
		$this->view = $view;
	}

	public function render( $vars ) {
		if ( is_array( $vars ) ) {      // если переменные заданы то разбиваем этот массив на отдельные переменные
			extract( $vars );
		}
		$file_view = TemplatePrefix . '/' . $this->route['controller'] . '/' . $this->view . TemplatePostfix;
		ob_start();
		if ( is_file( $file_view ) ) {
			require $file_view;
		} else {
			echo "<p>Не найден вид <b>$file_view</b></p>";
		}
		$content = ob_get_clean();

		if ( false !== $this->layout ) {    // если шаблон не false
			$file_layout = TemplatePrefix . '/layouts/' . $this->layout . TemplatePostfix;
			if ( is_file( $file_layout ) ) {
				require $file_layout;
			} else {
				echo "<p>Не найден шаблон <b>$file_layout</b></p>";
			}
		}
	}
}