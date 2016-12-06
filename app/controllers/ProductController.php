<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 06.12.2016
 * Time: 18:04
 */

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use app\models\Project;
use core\base\Controller;

class ProductController extends Controller {

	public $layout = 'main';

	/**
	 * Формирование страницы с индексом определенной категории
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

		$product       = $productModel->findById( $id );
		$projects      = $projectModel->findByProductId( $id );

		$title = "Custom Light. {$product[0]['name']}";
		$this->set( compact( 'title', 'categoryNames', 'projectNames', 'products', 'categoryHeader', 'projects' ) );
	}

}