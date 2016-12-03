<?php
/**
 *  Контроллер главной страницы
 */

// подключаем модели
require_once '../models/CategoryModel.php';
//require_once '../models/ProductModel.php';
//require_once '../models/ProjectModel.php';

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

		$mainSection = "blocks/index_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. Нестандартное освещение' );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'mainSection', $mainSection );



		Venom::loadTemplate( $smarty, 'general' );
	}
}