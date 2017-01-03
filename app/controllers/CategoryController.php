<?php

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use app\models\Project;
use core\Error;

class CategoryController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование страницы с индексом определенной категории
	 *
	 */
	public function indexAction( $categoryId = null ) {

		if ( $categoryId == null ) {
			Error::e404( 'Категория не задана!' );
		}

		$categoryModel  = new Category();
		$projectModel   = new Project;
		$productModel   = new Product;
		$categoryHeader = $categoryModel->findCategoryBrief( $categoryId );
		$products       = $productModel->findByCategory( $categoryId );
		$projects       = $projectModel->findByCategory( $categoryId );

		$title = APP_NAME . ". {$categoryHeader['name']}";
		$this->set( [
			'title'            => $title,
			'products'         => $products,
			'categoryHeader'   => $categoryHeader,
			'projects'         => $projects,
			'layoutEssentials' => $this->layoutEssentials
		] );
	}
}