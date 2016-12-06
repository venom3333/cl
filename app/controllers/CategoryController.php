<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 05.12.2016
 * Time: 18:39
 */

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use app\models\Project;
use core\base\Controller;

class CategoryController extends Controller {

	public $layout = 'main';

	/**
	 * Формирование страницы с индексом определенной категории
	 *
	 */
	public function indexAction( $categoryId = null ) {

		$categoryModel = new Category();
		$projectModel  = new Project;
		$productModel  = new Product;
		//< для меню и левой навигации
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$categoryHeader = $categoryModel->findCategoryBrief( $categoryId );
		$products       = $productModel->findByCategory( $categoryId );
		$projects       = $projectModel->findByCategory( $categoryId );

		$title = "Custom Light. {$categoryHeader[0]['name']}";
		$this->set( compact( 'title', 'categoryNames', 'projectNames', 'products', 'categoryHeader', 'projects' ) );
	}
}