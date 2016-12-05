<?php
/**
 *  Контроллер главной страницы
 */

namespace app\controllers;

use app\models\Category;


class MainController extends AppController {

	public $layout = 'main';

	public function testAction() {
		$model      = new Category;

		$categories = $model->findAll();

		$title = 'ТЕСТ ТАЙТЛ';
		$this->set( compact( 'title', 'categories' ) );
	}

	/**
	 * Формирование главной страницы сайта (список категорий)
	 *
	 */
	public function indexAction() {
		$model      = new Category;

		$title = 'Custom Light. Нестандартное освещение';
		$this->set( compact( 'title' ) );
	}
}