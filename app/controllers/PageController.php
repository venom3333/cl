<?php

namespace app\controllers;

use app\models\Page;

class PageController extends AppController {

	public $layout = 'main';

	/**
	 * Формирование выбранной текстовой (информационной) страницы
	 *
	 * @param string $alias алиас запрашиваемой страницы
	 */
	public function indexAction( $alias = null ) {

		$this->view       = 'page';

		$pageModel = new Page;
		$page      = $pageModel->findByAlias( $alias );

		$title = APP_NAME . '. ' . $page['name'];

		$this->setVars( [ 'title' => $title, 'layoutEssentials' => $this->layoutEssentials, 'page' => $page ] );
	}

}