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
	 * Формирование главной страницы сайта
	 *
	 */
	public function indexAction() {
//		$this->layout = 'main';
//		$this->view = 'test';
		$name       = 'Вован';
		$hi         = 'Hellou';
		$title      = 'ПЕЙДЖ ТАЙТЛ';
		$categories = Category::getMainCats();
		$this->set( compact( [ 'title', 'name', 'hi', 'categories' ] ) );
	}
}