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

	/**
	 * Формирование главной страницы админки
	 */
	public function indexAction() {
		$title = "Административная панель. Главная.";
		$this->set( compact( 'title' ) );
	}

	/**
	 * Формирование страницы админки с манипуляциями над продуктами
	 */
	public function productsAction() {
		$this->view   = "products";
		$productModel = new Product;
		$title        = "Работа с базой даннных. Продукты.";
		$products     = $productModel->getProductsForAdmin();
		$this->set( compact( 'title', 'products' ) );
	}


	/**
	 * Меняет статус видимости продукта и затем
	 * формирует страницу админки с манипуляциями над продуктами
	 */
	public function toggleProductStatusAction( $productId ) {
		$productModel = new Product;
		$productModel->toggleStatus( $productId );
		$this->productsAction();
	}

	/**
	 * Формирование страницы админки с манипуляциями над проектами
	 */
	public function projectsAction() {
		$this->view   = "projects";
		$projectModel = new Project;
		$projects     = $projectModel->getProjectsForAdmin();

		$title        = "Работа с базой даннных. Проекты.";
		$this->set( compact( 'title', 'projects' ) );
	}

	/**
	 * Формирование страницы админки с манипуляциями над категориями
	 */
	public function categoriesAction() {
		$title = "Работа с базой даннных. Категории.";
		$this->set( compact( 'title' ) );
	}

	/**
	 * Формирование страницы админки с формой создания продукта
	 */
	public function newProductAction() {

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый продукт.";
		$this->set( compact( 'title', 'categories' ) );
	}

	/**
	 * Формирование страницы админки с формой создания проекта
	 */
	public function newProjectAction() {

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый проект.";
		$this->set( compact( 'title', 'categories' ) );
	}

	/**
	 * Создает новый продукт и затем
	 * формирует страницу админки с манипуляциями над продуктами
	 */
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

	/**
	 * Удаляет определенный продукт и затем
	 * формирует страницу админки с манипуляциями над продуктами
	 */
	public function removeProductAction( $productId ) {

		$productModel = new Product;
		$productModel->removeProduct( $productId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: http://custom-light/admin/products' );
		exit();
	}

	/**
	 * Создает новый проект и затем
	 * формирует страницу админки с манипуляциями над проектами
	 */
	public function createProjectAction() {
		// принимаем всю переданную информацию и удобно складываем в массив
		// основное
		$project = [
			'name'             => $_POST['projectName'],
			'shortDescription' => $_POST['projectShortDescription'],
			'description'      => $_POST['projectDescription'],
			'icon'             => $_FILES['projectIcon'],
		];
		// категории
		foreach ( $_POST as $key => $value ) {
			if ( preg_match( "~^category[1-9]+~", $key ) ) {
				$project['categories'][] = $value;
			}
		}
		// изображения
		foreach ( $_FILES as $key => $value ) {
			if ( preg_match( "~^projectImage[1-9]+~", $key ) ) {
				$project['images'][] = $value;
			}
		}
		$projectModel = new Project;
		$projectModel->createProject( $project );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: http://custom-light/admin/projects' );
		exit();
	}

	/**
	 * Удаляет определенный проект и затем
	 * формирует страницу админки с манипуляциями над проектами
	 */
	public function removeProjectAction( $projectId ) {

		$projectModel = new Project;
		$projectModel->removeProject( $projectId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: http://custom-light/admin/projects' );
		exit();
	}

}