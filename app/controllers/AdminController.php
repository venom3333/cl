<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 13.12.2016
 * Time: 18:51
 */

namespace app\controllers;


use app\models\Category;
use app\models\Product;
use app\models\Project;

class AdminController extends AppController {

	public $layout = 'admin';

	public function indexAction() {


		$title = "Административная панель. Главная.";

		$this->set( compact( 'title' ) );

	}

	public function productsAction() {

		$productModel = new Product;
		$title        = "Работа с базой даннных. Продукты.";

		$products = $productModel->getProductsForAdmin();

		$this->set( compact( 'title', 'products' ) );

		//d($products);

	}

	public function projectsAction() {


		$title = "Работа с базой даннных. Проекты.";

		$this->set( compact( 'title' ) );

	}

	public function categoriesAction() {


		$title = "Работа с базой даннных. Категории.";

		$this->set( compact( 'title' ) );

	}

}