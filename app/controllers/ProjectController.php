<?php
/**
 * Class ProjectController контроллер проектов
 */

namespace app\controllers;

// подключаем модели
use app\models\CategoryModel;
use app\models\ProjectModel;
use core\Venom;

class ProjectController {

	/**
	 * экшн поумолчанию (для коротких ЧПУ)
	 *
	 * @param \Smarty $smarty шаблонизатор
	 * @param integer $projectId ID проекта
	 */
	public static function indexAction( \Smarty $smarty, $projectId ) {
		self::showAction( $smarty, $projectId);
	}

	/**
	 * выводит информацию о проекте
	 *
	 * @param \Smarty $smarty шаблонизатор
	 * @param integer $projectId ID проекта
	 */
	public static function showAction( \Smarty $smarty, $projectId ) {
		//< Для навигационного меню
		$categories = CategoryModel::getMainCats();
		$projectNames = ProjectModel::getProjectNames();
		//>
		$project = ProjectModel::getProject( $projectId );

		$mainSection = "blocks/project_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light.  ' . $project['name'] );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'project', $project );
		$smarty->assign( 'mainSection', $mainSection );


		Venom::loadTemplate( $smarty, 'general' );
	}

}