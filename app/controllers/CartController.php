<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 08.12.2016
 * Time: 16:16
 */

namespace app\controllers;


use app\models\Category;
use app\models\Project;

class CartController extends AppController {

	public $layout = 'main';

	public function indexAction() {
		//< для меню и левой навигации
		$categoryModel = new Category;
		$projectModel  = new Project;
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$this->view = 'cart';

		$title = "Custom Light. Корзина. Оформление заказа.";
		$this->set( compact( 'title', 'categoryNames', 'projectNames') );

	}

}