<?php
/**
 * Class ErrorController контроллер обработки ошибок
 */

// подключаем модели
require_once '../models/CategoryModel.php';
require_once '../models/ProductModel.php';
require_once '../models/ProjectModel.php';

class ErrorController {

	/**
	 * Выводит страницу 404
	 *
	 * @param Smarty $smarty объект шаблонизатора
	 */
	public static function e404( Smarty $smarty, $msg = null ) {
		$categories = CategoryModel::getMainCats();

		$mainSection = "blocks/404_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light. 404 Запрашиваемая страница не найдена.' );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'mainSection', $mainSection );

		if ( $msg ) {
			$smarty->assign( 'message', $msg );
		}


		http_response_code( 404 );
		Venom::loadTemplate( $smarty, 'general' );

		die;
	}

}