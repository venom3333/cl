<?php
/**
 *  Контроллер страницы категории
 */

namespace app\controllers;

// подключаем модели
use app\models\Category;
use app\models\Product;
use app\models\Project;
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
		$categories = Category::getMainCats();
		$projectNames = Project::getProjectNames();
		//>
		$categoryHeader = Category::getCategoryHeader( $categoryId );
		$products = Product::getIndexOfProducts( $categoryId );
		$projects = Project::getProjectsByCategory( $categoryId );

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