<?php
/**
 *  Контроллер страницы категории
 */

// подключаем модели
require_once '../models/CategoryModel.php';
require_once '../models/ProductModel.php';
require_once '../models/ProjectModel.php';

class CategoryController {
	/**
	 * Формирование главной страницы сайта
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param integer $categoryId ID категории продуктов
	 */
	public static function indexAction( Smarty $smarty, $categoryId ) {
		$categories = CategoryModel::getMainCats();
		$categoryHeader = CategoryModel::getCategoryHeader( $categoryId );
		$products = ProductModel::getIndexOfProducts( $categoryId );
		$projects = ProjectModel::getProjectsByCategory( $categoryId );

		$mainSection = "blocks/category_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. ' . $categoryHeader['name'] );    // тайтл страницы
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'categoryHeader', $categoryHeader );
		$smarty->assign( 'products', $products );
		$smarty->assign( 'projects', $projects );
		$smarty->assign( 'mainSection', $mainSection );

		Venom::loadTemplate( $smarty, 'general' );
	}
}