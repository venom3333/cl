<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 06.12.2016
 * Time: 23:13
 */

namespace app\controllers;


use app\models\Category;
use app\models\Project;

class ProjectController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование страницы с определенным проектом
	 *
	 */
	public function indexAction( $id = null ) {

		$categoryModel = new Category;
		$projectModel  = new Project;
		//< для меню и левой навигации
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$project = $projectModel->findById( $id );

		$this->view = 'project';

		$title = "Custom Light. {$project['name']}";
		$this->set( compact( 'title', 'categoryNames', 'projectNames', 'project' ) );
	}
}