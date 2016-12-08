<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 08.12.2016
 * Time: 14:21
 */

namespace app\controllers;

use app\models\Category;
use app\models\Project;

class PageController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование выбранной текстовой (информационной) страницы
	 *
	 */
	public function indexAction( $alias = null ) {

		$categoryModel = new Category;
		$projectModel  = new Project;
		//< для меню и левой навигации
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$this->view = $alias;

		$title = "Custom Light.";

		switch ( $alias ) {
			case 'about':
				$title = " О компании."; break;
			case 'contacts':
				$title = " Контакты."; break;
			case 'designers':
				$title = " Дизайнерам и архитекторам."; break;

		}

		$this->set( compact( 'title', 'categoryNames', 'projectNames', 'categoryHeader') );
	}

}