<?php
/**
 *  Контроллер главной страницы
 */

// подключаем модели
require_once '../models/CategoryModel.php';
require_once '../models/ProductModel.php';

class IndexController {

	public static function testAction() {
		echo 'IndexController.php > testAction';
	}

	/**
	 * Формирование главной страницы сайта
	 *
	 * @param Smarty $smarty шаблонизатор
	 */
	public static function indexAction( Smarty $smarty ) {
		$categories = CategoryModel::getMainCats();

		$smarty->assign( 'pageTitle', 'Custom Light. Нестандартное освещение' );
		$smarty->assign( 'categories', $categories );

		//d($rsItems);

		Venom::loadTemplate( $smarty, 'index' );
	}

	/**
	 * Формирование главной страницы сайта
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param integer $categoryId ID категории продуктов
	 */
	public static function categoryAction( Smarty $smarty, $categoryId = 8 ) {
		$categories = CategoryModel::getMainCats();

		$categoryHeader = CategoryModel::getCategoryHeader( $categoryId );

		$products = ProductModel::getIndexOfProducts( $categoryId );

		//d($products);

		$smarty->assign( 'pageTitle', 'Custom Light. Категория 1' );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'products', $products );
		$smarty->assign( 'categoryHeader', $categoryHeader );

		//d($rsItems);

		Venom::loadTemplate( $smarty, 'category' );
	}
}