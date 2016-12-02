<?php
/**
 * Class ProjectController контроллер проектов
 */

// подключаем модели
require_once '../models/CategoryModel.php';
require_once '../models/ProjectModel.php';

class ProjectController {

	/**
	 * экшн поумолчанию (для коротких ЧПУ)
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param integer $projectId ID проекта
	 */
	public static function indexAction( Smarty $smarty, $projectId ) {
		self::showAction( $smarty, $projectId);
	}

	/**
	 * выводит информацию о проекте
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param integer $projectId ID проекта
	 */
	public static function showAction( Smarty $smarty, $projectId ) {
		$categories = CategoryModel::getMainCats();
		$project = ProjectModel::getProject( $projectId );

		$smarty->assign( 'pageTitle', 'Custom Light.  ' . $project['name'] );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'project', $project );


		Venom::loadTemplate( $smarty, 'project' );
	}

}