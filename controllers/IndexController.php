<?php
/**
 *  Контроллер главной страницы
 */

// подключаем модели
include_once '../models/CategoryModel.php';
include_once '../models/ProductModel.php';

function testAction () {
	echo 'IndexController.php > testAction';
}

/**
 * Формирование главной страницы сайта
 *
 * @param Smarty $smarty шаблонизатор
 */
function indexAction(Smarty $smarty){
	$categories = getMainCats();

	$smarty->assign('pageTitle', 'Custom Light. Нестандартное освещение');
	$smarty->assign('categories', $categories);

	//d($rsItems);

	loadTemplate($smarty, 'index');
}

/**
 * Формирование главной страницы сайта
 *
 * @param Smarty $smarty шаблонизатор
 * @param integer $categoryId ID категории продуктов
 */
function categoryAction(Smarty $smarty, $categoryId = 8){
	$categories = getMainCats();

	$categoryHeader = getCategoryHeader($categoryId);

	$products = getIndexOfProducts($categoryId);

	//d($products);

	$smarty->assign('pageTitle', 'Custom Light. Категория 1');
	$smarty->assign('categories', $categories);
	$smarty->assign('products', $products);
	$smarty->assign('categoryHeader', $categoryHeader);

	//d($rsItems);

	loadTemplate($smarty, 'category');
}