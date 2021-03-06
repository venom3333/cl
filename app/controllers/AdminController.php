<?php
namespace app\controllers;


use app\models\Category;
use app\models\Product;
use app\models\Project;
use app\models\Page;

class AdminController extends AppController {

	public $layout = 'admin';
	protected $auth = true;
	protected $authCategory = 'authAdmin';

	// Пример установки отдельного пароля (пароли хранятся в виде результата фукции password_hash()):
	/*
	public function __construct( array $route ) {
		$this->setPass( password_hash( "password", PASSWORD_BCRYPT ) );
		parent::__construct( $route );
	}*/

	// обработаем неавторизованного пользователя по свОему
	protected function is_auth(){
		if(!parent::is_auth()){
			header('Location: /admin');
			exit();
		}

		return true;
	}

	/**
	 * Формирование главной страницы админки
	 */
	public function indexAction(){
		$title = "Административная панель. Главная.";
		$this->setVars(compact('title'));
	}


	// ПРОДУКТЫ
	/**
	 * Формирование страницы админки с манипуляциями над продуктами
	 */
	public function productsAction(){
		$this->view   = "products";
		$productModel = new Product;
		$title        = "Работа с базой даннных. Продукты.";
		$products     = $productModel->getProductsForAdmin();
		$this->setVars(compact('title', 'products'));
	}

	/**
	 * Меняет статус видимости продукта и затем
	 * формирует страницу админки с манипуляциями над продуктами
	 *
	 * @param int $productId id продукта
	 */
	public function toggleProductStatusAction(int $productId){
		$productModel = new Product;
		$productModel->toggleStatus($productId);
		$this->productsAction();
	}

	/**
	 * Формирование страницы админки с формой создания нового продукта
	 */
	public function newProductAction(){

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый продукт.";
		$this->setVars(compact('title', 'categories'));
	}

	/**
	 * Создает новый продукт и затем
	 * формирует страницу админки с манипуляциями над продуктами
	 */
	public function createProductAction(){
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
		foreach($_POST as $key => $value){
			if(preg_match("~^category[1-9]+~", $key)){
				$product['categories'][] = $value;
			}
		}
// изображения
		foreach($_FILES as $key => $value){
			if(preg_match("~^productImage[1-9]+~", $key)){
				$product['images'][] = $value;
			}
		}
// варианты
// сколько вариантов пришло (т.к. price - обязательный параметр, считаем сколько их)
		$specsCounter = 0;
		foreach($_POST as $key => $value){
			if(preg_match("~^productPrice[1-9]+~", $key)){
				$specsCounter ++;
			}
		}

		for($i = 1; $i <= $specsCounter; $i ++){
			if(!$_POST["productPrice$i"]){
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
		$productModel->createProduct($product);

		$this->productsAction();
	}

	/**
	 * Удаляет определенный продукт и затем
	 * формирует страницу админки с манипуляциями над продуктами
	 *
	 * @param int $productId id продукта
	 */
	public
	function removeProductAction(
		int $productId
	){

		$productModel = new Product;
		$productModel->removeProduct($productId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/products');
		exit();
	}

	/**
	 * Формирует страницу админки с редактированием определенного продукта     *
	 *
	 * @param int $productId id категории
	 */
	public
	function editProductAction(
		int $productId
	){

		$productModel    = new Product;
		$categoriesModel = new Category;
		$product         = $productModel->findById($productId);
		$categories      = $categoriesModel->findAllNames();
		$title           = "Работа с базой даннных. Редактирование Продукта $productId.";
		$this->setVars(compact('title', 'product', 'categories'));
	}

	/**
	 * Перезаписывает (обновляет) основную информацию определенного продукта и затем
	 * перезагружает страницу админки с редактированием текущего продукта
	 *
	 * @param int $productId id продукта
	 */
	public
	function updateProductAction(
		int $productId
	){

		$updatedProduct ['id']                = $_POST ['productId'];
		$updatedProduct ['name']              = $_POST ['productName'];
		$updatedProduct ['short_description'] = $_POST ['productShortDescription'];
		$updatedProduct ['description']       = $_POST ['productDescription'];
		$updatedProduct ['currentIcon']       = $_POST ['productCurrentIcon'];
		$updatedProduct ['icon']              = $_FILES['productIcon'];

		$projectModel = new Product;

		$projectModel->updateMain($productId, $updatedProduct);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-product/$productId");
		exit();
	}

	/**
	 * Перезаписывает (обновляет) информацию о категориях определенного продукта и затем
	 * перезагружает страницу админки с редактированием текущего продукта
	 *
	 * @param int $productId id продукта
	 */
	public
	function updateProductCategoriesAction(
		int $productId
	){

		$categories = array();
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			foreach($_POST as $category){
				$categories[] = $category;
			}
		}

		$productModel = new Product;

		$productModel->updateCategories($productId, $categories);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-product/$productId");
		exit();
	}

	/**
	 *  Добавляет изображение продукту
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $productId id продукта
	 */
	public
	function addProductImageAction(
		int $productId
	){

		if(!$_FILES['productImage']['error']){
			$image        = $_FILES['productImage'];
			$productModel = new Product;

			$productModel->addImage($productId, $image);
		}
		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-product/$productId");
		exit();
	}

	/**
	 *  Удаляет определенное изображение из продукта
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $imageId id изображения
	 *     * @param int $productId id продукта для определения страницу с каким продуктом затем открыть в "Location:"
	 */
	public
	function removeProductImageAction(
		int $imageId, $productId
	){
		$productModel = new Product;
		$productModel->removeImage($imageId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-product/$productId");
		exit();
	}

	/**
	 *  Добавляет спецификацию продукта
	 *    и перезагружает страницу админки с редактированием текущего продукта
	 *
	 *     * @param int $productId id продукта
	 */
	public
	function addProductSpecificationAction(
		int $productId
	){

		$specification = array();
		foreach($_POST as $key => $value){
			if($value){
				$specification [ $key ] = $value;
			}else{
				$specification [ $key ] = 0;
			}
		}

		$productModel = new Product;
		$productModel->addSpecification($productId, $specification);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-product/$productId");
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
	){

		$productModel = new Product;
		$productModel->removeSpecification($specificationId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-product/$productId");
		exit();
	}


// ПРОЕКТЫ
	/**
	 * Формирование страницы админки с манипуляциями над проектами
	 */
	public
	function projectsAction(){
		$this->view   = "projects";
		$projectModel = new Project;
		$projects     = $projectModel->getProjectsForAdmin();

		$title = "Работа с базой даннных. Проекты.";
		$this->setVars(compact('title', 'projects'));
	}

	/**
	 * Формирование страницы админки с формой создания нового проекта
	 */
	public
	function newProjectAction(){

		$categoryModel = new Category;
		$categories    = $categoryModel->findAllNames();

		$title = "Работа с базой даннных. Новый проект.";
		$this->setVars(compact('title', 'categories'));
	}

	/**
	 * Создает новый проект и затем
	 * формирует страницу админки с манипуляциями над проектами
	 */
	public
	function createProjectAction(){
		// принимаем всю переданную информацию и удобно складываем в массив
		// основное
		$project = [
			'name'             => $_POST['projectName'],
			'shortDescription' => $_POST['projectShortDescription'],
			'description'      => $_POST['projectDescription'],
			'icon'             => $_FILES['projectIcon'],
		];
		// категории
		foreach($_POST as $key => $value){
			if(preg_match("~^category[1-9]+~", $key)){
				$project['categories'][] = $value;
			}
		}
		// изображения
		foreach($_FILES as $key => $value){
			if(preg_match("~^projectImage[1-9]+~", $key)){
				$project['images'][] = $value;
			}
		}
		$projectModel = new Project;
		$projectModel->createProject($project);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/projects');
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
	){

		$projectModel = new Project;
		$projectModel->removeProject($projectId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/projects');
		exit();
	}

	/**
	 * Формирует страницу админки с редактированием определенного проекта     *
	 *
	 * @param int $projectId id категории
	 */
	public
	function editProjectAction(
		int $projectId
	){

		$projectModel    = new Project;
		$categoriesModel = new Category;
		$project         = $projectModel->findById($projectId);
		$categories      = $categoriesModel->findAllNames();
		$title           = "Работа с базой даннных. Редактирование Проекта $projectId.";
		$this->setVars(compact('title', 'project', 'categories'));
	}

	/**
	 * Перезаписывает (обновляет) основную информацию определенного проекта и затем
	 * перезагружает страницу админки с редактированием текущего проекта
	 *
	 * @param int $projectId id проекта
	 */
	public
	function updateProjectAction(
		int $projectId
	){

		$updatedProject ['id']                = $_POST ['projectId'];
		$updatedProject ['name']              = $_POST ['projectName'];
		$updatedProject ['short_description'] = $_POST ['projectShortDescription'];
		$updatedProject ['description']       = $_POST ['projectDescription'];
		$updatedProject ['currentIcon']       = $_POST ['projectCurrentIcon'];
		$updatedProject ['icon']              = $_FILES['projectIcon'];

		$projectModel = new Project;

		$projectModel->updateMain($projectId, $updatedProject);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-project/$projectId");
		exit();
	}

	/**
	 * Перезаписывает (обновляет) информацию о категориях определенного проекта и затем
	 * перезагружает страницу админки с редактированием текущего проекта
	 *
	 * @param int $projectId id проекта
	 */
	public
	function updateProjectCategoriesAction(
		int $projectId
	){

		$categories = array();
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			foreach($_POST as $category){
				$categories[] = $category;
			}
		}

		$projectModel = new Project;

		$projectModel->updateCategories($projectId, $categories);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-project/$projectId");
		exit();
	}

	/**
	 *  Добавляет изображение проекту
	 *    и перезагружает страницу админки с редактированием текущего проекта
	 *
	 *     * @param int $projectId id проекта
	 */
	public
	function addProjectImageAction(
		int $projectId
	){

		if(!$_FILES['projectImage']['error']){
			$image        = $_FILES['projectImage'];
			$projectModel = new Project;

			$projectModel->addImage($projectId, $image);
		}
		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-project/$projectId");
		exit();
	}

	/**
	 *  Удаляет определенное изображение из проекта
	 *    и перезагружает страницу админки с редактированием текущего проекта
	 *
	 *     * @param int $imageId id изображения
	 *     * @param int $projectId id проекта для определения страницу с каким проектом затем открыть в "Location:"
	 */
	public
	function removeProjectImageAction(
		int $imageId, $projectId
	){

		$projectModel = new Project;
		$projectModel->removeImage($imageId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header("Location: /admin/edit-project/$projectId");
		exit();
	}

// КАТЕГОРИИ
	/**
	 * Формирование страницы админки с манипуляциями над категориями
	 */
	public
	function categoriesAction(){
		$categoryModel = new Category;
		$categories    = $categoryModel->findAll();
		$title         = "Работа с базой даннных. Категории.";
		$this->setVars(compact('title', 'categories'));
	}

	/**
	 * Формирование страницы админки с формой создания новой категории
	 */
	public
	function newCategoryAction(){

		$title = "Работа с базой даннных. Новая Категория.";
		$this->setVars(compact('title'));

	}

	/**
	 * Создает новую категорию и затем
	 * формирует страницу админки с манипуляциями над категориями
	 */
	public
	function createCategoryAction(){
		// принимаем всю переданную информацию и удобно складываем в массив
		// основное
		$category = [
			'name'             => $_POST['categoryName'],
			'shortDescription' => $_POST['categoryShortDescription'],
			'description'      => $_POST['categoryDescription'],
			'icon'             => $_FILES['categoryIcon'],
		];

		$projectModel = new Category;
		$projectModel->createCategory($category);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/categories/');
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
	){
		$projectModel = new Category;
		$projectModel->removeCategory($categoryId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/categories');
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
	){

		$categoryModel = new Category;
		$category      = $categoryModel->findById($categoryId);
		$title         = "Работа с базой даннных. Редактирование Категории $categoryId.";
		$this->setVars(compact('title', 'category'));
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
	){

		$updatedCategory ['id']                = $_POST ['categoryId'];
		$updatedCategory ['name']              = $_POST ['categoryName'];
		$updatedCategory ['short_description'] = $_POST ['categoryShortDescription'];
		$updatedCategory ['description']       = $_POST ['categoryDescription'];
		$updatedCategory ['currentIcon']       = $_POST ['categoryCurrentIcon'];
		$updatedCategory ['icon']              = $_FILES['categoryIcon'];

		$projectModel = new Category;

		$projectModel->updateCategory($categoryId, $updatedCategory);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/categories');
		exit();
	}

// СТРАНИЦЫ
	/**
	 * Формирование страницы админки с манипуляциями над страницами
	 */
	public
	function pagesAction(){
		$pageModel = new Page;
		$pages     = $pageModel->findAll();
		$title     = "Работа с базой даннных. Категории.";
		$this->setVars(compact('title', 'pages'));
	}

	/**
	 * Формирование страницы админки с формой создания новой страницы
	 */
	public
	function newPageAction(){

		$title = "Работа с базой даннных. Новая Страница.";
		$this->setVars(compact('title'));

	}

	/**
	 * Создает новую страницу и затем
	 * формирует страницу админки с манипуляциями над страницами
	 */
	public
	function createPageAction(){
		// принимаем всю переданную информацию и удобно складываем в массив
		// основное
		$page = [
			'name'    => $_POST['pageName'],
			'alias'   => $_POST['pageAlias'],
			'content' => $_POST['pageContent'],
		];

		$pageModel = new Page;
		$pageModel->createPage($page);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/pages/');
		exit();
	}

	/**
	 * Удаляет определенную страницу и затем
	 * формирует страницу админки с манипуляциями над страницами
	 *
	 * @param int $pageId id категории
	 */
	public
	function removePageAction(
		int $pageId
	){
		$pageModel = new Page;
		$pageModel->removePage($pageId);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/pages');
		exit();
	}

	/**
	 * Формирует страницу админки с редактированием определенной страницы     *
	 *
	 * @param int $pageId id категории
	 */
	public
	function editPageAction(
		int $pageId
	){
		$pageModel = new Page;
		$page      = $pageModel->findById($pageId)[0];
		$title     = "Работа с базой даннных. Редактирование страницы с ID = $pageId.";
		$this->setVars(compact('title', 'page'));
	}

	/**
	 * Перезаписывает (обновляет) определенную страницу и затем
	 * формирует страницу админки с манипуляциями над страницами
	 *
	 * @param int $pageId id категории
	 */
	public
	function updatePageAction(
		int $pageId
	){
		$updatedPage ['name']    = $_POST ['pageName'];
		$updatedPage ['alias']   = $_POST ['pageAlias'];
		$updatedPage ['content'] = $_POST ['pageContent'];

		$pageModel = new Page;

		$pageModel->updatePage($pageId, $updatedPage);

		// для тех кто без параметров (чтобы не было ошибок с обновлением страницы т.п. вещами)
		header('Location: /admin/pages');
		exit();
	}
}

