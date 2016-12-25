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


	// ПРОДУКТЫ
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
	 *
	 * @param int $productId id продукта
	 */
	public function toggleProductStatusAction( int $productId ) {
		$productModel = new Product;
		$productModel->toggleStatus( $productId );
		$this->productsAction();
	}

	/**
	 * Формирование страницы админки с формой создания нового продукта
	 */
	public function newProductAction() {

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый продукт.";
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
	 *
	 * @param int $productId id продукта
	 */
	public function removeProductAction( int $productId ) {

		$productModel = new Product;
		$productModel->removeProduct( $productId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: /admin/products' );
		exit();
	}

	/**
	 * Формирует страницу админки с редактированием определенного продукта     *
	 *
	 * @param int $productId id категории
	 */
	public function editProductAction( int $productId ) {

		$productModel    = new Product;
		$categoriesModel = new Category;
		$product         = $productModel->findById( $productId );
		$categories      = $categoriesModel->findAllNames();
		$title           = "Работа с базой даннных. Редактирование Продукта $productId.";
		$this->set( compact( 'title', 'product', 'categories' ) );
	}

	/**
	 * Перезаписывает (обновляет) основную информацию определенного продукта и затем
	 * перезагружает страницу админки с редактированием текущего продукта
	 *
	 * @param int $productId id продукта
	 */
	public function updateProductAction( int $productId ) {

		$updatedProduct ['id']                = $_POST ['productId'];
		$updatedProduct ['name']              = $_POST ['productName'];
		$updatedProduct ['short_description'] = $_POST ['productShortDescription'];
		$updatedProduct ['description']       = $_POST ['productDescription'];
		$updatedProduct ['currentIcon']       = $_POST ['productCurrentIcon'];
		$updatedProduct ['icon']              = $_FILES['productIcon'];

		$projectModel = new Product;

		$projectModel->updateMain( $productId, $updatedProduct );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( "Location: /admin/edit-product/$productId" );
		exit();
	}

	/**
	 * Перезаписывает (обновляет) информацию о категориях определенного продукта и затем
	 * перезагружает страницу админки с редактированием текущего продукта
	 *
	 * @param int $productId id продукта
	 */
	public function updateProductCategoriesAction( int $productId ) {

		$categories = array();
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
			foreach ( $_POST as $category ) {
				$categories[] = $category;
			}
		}

		$productModel = new Product;

		$productModel->updateCategories( $productId, $categories );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( "Location: /admin/edit-product/$productId" );
		exit();
	}

	/**
	 *  Добавляет изображение продукту
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $productId id продукта
	 */
	public function addProductImageAction( int $productId ) {

		if ( ! $_FILES['productImage']['error'] ) {
			$image        = $_FILES['productImage'];
			$productModel = new Product;

			$productModel->addImage( $productId, $image );
		}
		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( "Location: /admin/edit-product/$productId" );
		exit();
	}

	/**
	 *  Удаляет определенное изображение из продукта
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $imageId id изображения
	 *     * @param int $productId id продукта для определения страницу с каким продуктом затем открыть в "Location:"
	 */
	public function removeProductImageAction( int $imageId, $productId ) {

		$productModel = new Product;
		$productModel->removeImage( $imageId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( "Location: /admin/edit-product/$productId" );
		exit();
	}

	/**
	 *  Добавляет спецификацию продукта
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $productId id продукта
	 */
	public function addProductSpecificationAction( int $productId ) {

		$specification = array();
		foreach ( $_POST as $key => $value ) {
			if ( $value ) {
				$specification [ $key ] = $value;
			} else {
				$specification [ $key ] = 0;
			}
		}

		$productModel = new Product;
		$productModel->addSpecification( $productId, $specification );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( "Location: /admin/edit-product/$productId" );
		exit();
	}

	/**
	 *  Удаляет определенную спецификацию из продукта
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $specificationId id спецификации
	 *     * @param int $productId id продукта для определения страницу с каким продуктом затем открыть в "Location:"
	 */
	public
	function removeProductSpecificationAction(
		int $specificationId, $productId
	) {

		$productModel = new Product;
		$productModel->removeSpecification( $specificationId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( "Location: /admin/edit-product/$productId" );
		exit();
	}


// ПРОЕКТЫ
	/**
	 * Формирование страницы админки с манипуляциями над проектами
	 */
	public
	function projectsAction() {
		$this->view   = "projects";
		$projectModel = new Project;
		$projects     = $projectModel->getProjectsForAdmin();

		$title = "Работа с базой даннных. Проекты.";
		$this->set( compact( 'title', 'projects' ) );
	}

	/**
	 * Формирование страницы админки с формой создания нового проекта
	 */
	public
	function newProjectAction() {

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый проект.";
		$this->set( compact( 'title', 'categories' ) );
	}

	/**
	 * Создает новый проект и затем
	 * формирует страницу админки с манипуляциями над проектами
	 */
	public
	function createProjectAction() {
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
		header( 'Location: /admin/projects' );
		exit();
	}

	/**
	 * Удаляет определенный проект и затем
	 * формирует страницу админки с манипуляциями над проектами
	 *
	 * @param int $projectId id проекта
	 */
	public
	function removeProjectAction(
		int $projectId
	) {

		$projectModel = new Project;
		$projectModel->removeProject( $projectId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: /admin/projects' );
		exit();
	}

// КАТЕГОРИИ
	/**
	 * Формирование страницы админки с манипуляциями над категориями
	 */
	public
	function categoriesAction() {
		$categoryModel = new Category;
		$categories    = $categoryModel->findAll();
		$title         = "Работа с базой даннных. Категории.";
		$this->set( compact( 'title', 'categories' ) );
	}

	/**
	 * Формирование страницы админки с формой создания новой категории
	 */
	public
	function newCategoryAction() {

		$title = "Работа с базой даннных. Новая Категория.";
		$this->set( compact( 'title' ) );

	}

	/**
	 * Создает новую категорию и затем
	 * формирует страницу админки с манипуляциями над категориями
	 */
	public
	function createCategoryAction() {
		// принимаем всю переданную информацию и удобно складываем в массив
		// основное
		$category = [
			'name'             => $_POST['categoryName'],
			'shortDescription' => $_POST['categoryShortDescription'],
			'description'      => $_POST['categoryDescription'],
			'icon'             => $_FILES['categoryIcon'],
		];

		$projectModel = new Category;
		$projectModel->createCategory( $category );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: /admin/categories/' );
		exit();
	}

	/**
	 * Удаляет определенную категорию и затем
	 * формирует страницу админки с манипуляциями над категориями
	 *
	 * @param int $categoryId id категории
	 */
	public
	function removeCategoryAction(
		int $categoryId
	) {
		$projectModel = new Category;
		$projectModel->removeCategory( $categoryId );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: /admin/categories' );
		exit();
	}

	/**
	 * Формирует страницу админки с редактированием определенной категории     *
	 *
	 * @param int $categoryId id категории
	 */
	public
	function editCategoryAction(
		int $categoryId
	) {

		$categoryModel = new Category;
		$category      = $categoryModel->findById( $categoryId );
		$title         = "Работа с базой даннных. Редактирование Категории $categoryId.";
		$this->set( compact( 'title', 'category' ) );
	}

	/**
	 * Перезаписывает (обновляет) определенную категорию и затем
	 * формирует страницу админки с манипуляциями над категориями
	 *
	 * @param int $categoryId id категории
	 */
	public
	function updateCategoryAction(
		int $categoryId
	) {

		$updatedCategory ['id']                = $_POST ['categoryId'];
		$updatedCategory ['name']              = $_POST ['categoryName'];
		$updatedCategory ['short_description'] = $_POST ['categoryShortDescription'];
		$updatedCategory ['description']       = $_POST ['categoryDescription'];
		$updatedCategory ['currentIcon']       = $_POST ['categoryCurrentIcon'];
		$updatedCategory ['icon']              = $_FILES['categoryIcon'];

		$projectModel = new Category;

		$projectModel->updateCategory( $categoryId, $updatedCategory );

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header( 'Location: /admin/categories' );
		exit();
	}
}

