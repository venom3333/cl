<?php
/**
 * Class ErrorController контроллер обработки ошибок
 */

namespace core;
// подключаем модели
use app\models\CategoryModel;
use app\models\ProjectModel;

class ErrorController {

	/**
	 * Выводит страницу 404
	 *
	 * @param \Smarty $smarty объект шаблонизатора
	 */
	public static function e404( $smarty, $msg = null ) {
		$categories = CategoryModel::getMainCats();
		$projectNames = ProjectModel::getProjectNames();

		$mainSection = "blocks/404_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. 404 Запрашиваемая страница не найдена.' );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'mainSection', $mainSection );

		if ( $msg ) {
			$smarty->assign( 'message', $msg );
		}

		http_response_code( 404 );
		Venom::loadTemplate( $smarty, 'general' );

		die;
	}

}