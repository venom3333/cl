<?php

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use app\models\Project;

class ProductController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование страницы с определенным продуктом
	 *
	 */
	public function indexAction( $id = null ) {

		$categoryModel = new Category;
		$projectModel  = new Project;
		$productModel  = new Product;
		//< для меню и левой навигации
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$product = $productModel->findById( $id );

		$this->view = 'product';

		$title = "Custom Light. {$product['name']}";
		$this->set( compact( 'title', 'categoryNames', 'projectNames', 'product' ) );
	}

}