<?php
/**
 *  Контроллер главной страницы
 */

namespace app\controllers;

use app\models\Category;


class HomeController extends AppController {

	//public $layout = 'default';

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
		$categoryModel = new Category;
		$categories    = $categoryModel->findAll();

		$title = APP_NAME . '. Нестандартное освещение';
		$this->set( [ 'title' => $title, 'categories' => $categories, 'layoutEssentials' => $this->layoutEssentials ] );
	}
}