<?php

namespace app\controllers;

use app\models\Project;

class ProjectController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование страницы с определенным проектом
	 *
	 */
	public function indexAction( $id = null ) {

		$projectModel = new Project;
		$project      = $projectModel->findById( $id );

		$this->view = 'project';

		$title = APP_NAME . ". {$project['name']}";
		$this->set( [ 'title' => $title, 'layoutEssentials' => $this->layoutEssentials, 'project' => $project ] );
	}
}