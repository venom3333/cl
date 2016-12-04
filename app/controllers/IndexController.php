<?php
/**
 *  Контроллер главной страницы
 */

namespace app\controllers;

// подключаем модели
use app\models\CategoryModel;
use app\models\ProjectModel;
use core\Venom;

class IndexController {

	public static function testAction() {
		echo 'IndexController.php > testAction';
		die();
	}

	/**
	 * Формирование главной страницы сайта
	 *
	 * @param \Smarty $smarty шаблонизатор
	 */
	public static function indexAction( \Smarty $smarty ) {

		//< Для навигационного меню
		$categories = CategoryModel::getMainCats();
		$projectNames = ProjectModel::getProjectNames();
		//>

		$mainSection = "blocks/index_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. Нестандартное освещение' );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'mainSection', $mainSection );

		Venom::loadTemplate( $smarty, 'general' );
	}
}