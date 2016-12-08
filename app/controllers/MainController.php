<?php
/**
 *  Контроллер главной страницы
 */

namespace app\controllers;

use app\models\Category;
use app\models\Project;


class MainController extends AppController {

	//public $layout = 'main';

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
		//< для меню и левой навигации
		$categoryModel = new Category;
		$projectModel  = new Project;
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$categories = $categoryModel->findAll();

		$title = 'Custom Light. Нестандартное освещение';
		$this->set( compact( 'title', 'categoryNames', 'projectNames', 'categories' ) );
	}
}