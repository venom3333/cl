<?php
/**
 *  Контроллер главной страницы
 */

namespace app\controllers;

// подключаем модели
use app\models\Category;
use app\models\Project;
use core\Venom;

class OldIndexController {

	public static function testAction() {
		echo 'OldIndexController.php > testAction';
		die();
	}

	/**
	 * Формирование главной страницы сайта
	 *
	 * @param \Smarty $smarty шаблонизатор
	 */
	public static function indexAction( \Smarty $smarty ) {

		//< Для навигационного меню
		$categories = Category::getMainCats();
		$projectNames = Project::getProjectNames();
		//>

		$mainSection = "blocks/index_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. Нестандартное освещение' );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'mainSection', $mainSection );

		Venom::loadTemplate( $smarty, 'general' );
	}
}