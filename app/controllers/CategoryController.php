<?php
/**
 *  Контроллер страницы категории
 */

namespace app\controllers;

// подключаем модели
use app\models\CategoryModel;
use app\models\ProductModel;
use app\models\ProjectModel;
use core\Venom;

class CategoryController {
	/**
	 * Формирование главной страницы сайта
	 *
	 * @param \Smarty $smarty шаблонизатор
	 * @param integer $categoryId ID категории продуктов
	 */
	public static function indexAction( $smarty, $categoryId = null) {
		//< Для навигационного меню
		$categories = CategoryModel::getMainCats();
		$projectNames = ProjectModel::getProjectNames();
		//>
		$categoryHeader = CategoryModel::getCategoryHeader( $categoryId );
		$products = ProductModel::getIndexOfProducts( $categoryId );
		$projects = ProjectModel::getProjectsByCategory( $categoryId );

		$mainSection = "blocks/category_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. ' . $categoryHeader['name'] );    // тайтл страницы
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'categoryHeader', $categoryHeader );
		$smarty->assign( 'products', $products );
		$smarty->assign( 'projects', $projects );
		$smarty->assign( 'mainSection', $mainSection );

		Venom::loadTemplate( $smarty, 'general' );
	}
}