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
		$this->view   = "products";
		$productModel = new Product;
		$title        = "Работа с базой даннных. Продукты.";
		$products     = $productModel->getProductsForAdmin();
		$this->set( compact( 'title', 'products' ) );
	}

	public function toggleProductStatusAction( $productId ) {
		$productModel = new Product;
		$productModel->toggleStatus( $productId );
		$this->productsAction();
	}

	public function projectsAction() {
		$title = "Работа с базой даннных. Проекты.";
		$this->set( compact( 'title' ) );
	}

	public function categoriesAction() {
		$title = "Работа с базой даннных. Категории.";
		$this->set( compact( 'title' ) );
	}

	public function newProductAction() {

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый продукт.";
		$this->set( compact( 'title', 'categories' ) );
	}

	public function createProductAction() {
		// принимаем всю переданную информацию и удобно складываем в массив
		// основное
		$product = [
			'name'             => $_POST['productName'],
			'status'           => $_POST['productStatus'],
			'shortDescription' => $_POST['productShortDescription'],
			'description'      => $_POST['productDescription'],
			'icon'             => $_FILES['productIcon'],
		];
		// категории
		foreach ( $_POST as $key => $value ) {
			if ( preg_match( "~^category[1-9]+~", $key ) ) {
				$product['categories'][] = $value;
			}
		}
		// изображения
		foreach ( $_FILES as $key => $value ) {
			if ( preg_match( "~^productImage[1-9]+~", $key ) ) {
				$product['images'][] = $value;
			}
		}
		// варианты
		// сколько вариантов пришло (т.к. price - обязательный параметр, считаем сколько их)
		$specsCounter = 0;
		foreach ( $_POST as $key => $value ) {
			if ( preg_match( "~^productPrice[1-9]+~", $key ) ) {
				$specsCounter ++;
			}
		}

		for ( $i = 1; $i <= $specsCounter; $i ++ ) {
			if ( ! $_POST["productPrice$i"] ) {
				continue;
			}
			$product['specifications'][ $i ]['price']        = $_POST["productPrice$i"];
			$product['specifications'][ $i ]['diameter']     = $_POST["productDiameter$i"];
			$product['specifications'][ $i ]['length']       = $_POST["productLength$i"];
			$product['specifications'][ $i ]['width']        = $_POST["productWidth$i"];
			$product['specifications'][ $i ]['height']       = $_POST["productHeight$i"];
			$product['specifications'][ $i ]['power']        = $_POST["productPower$i"];
			$product['specifications'][ $i ]['light_output'] = $_POST["productLightOutput$i"];
		}

		$productModel = new Product;
		$productModel->createProduct( $product );

		$this->productsAction();
	}

	public function removeProductAction( $productId ) {

		$productModel = new Product;
		$productModel->removeProduct( $productId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: http://custom-light/admin/products');
		exit();
	}

}