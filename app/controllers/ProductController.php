<?php

namespace app\controllers;


use app\models\Product;

class ProductController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование страницы с определенным продуктом
	 *
	 */
	public function indexAction( $id = null ) {

		$productModel  = new Product;
		$product = $productModel->findById( $id );

		$this->view = 'product';

		$title = APP_NAME . ". {$product['name']}";
		$this->setVars( [ 'title' => $title, 'layoutEssentials' => $this->layoutEssentials, 'product' => $product ] );
	}

}