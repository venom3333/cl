<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 05.12.2016
 * Time: 14:03
 */

namespace app\controllers;


use app\models\Category;
use app\models\Project;
use app\models\Page;
use core\base\Controller;

abstract class AppController extends Controller {
	protected $layoutEssentials = array();

	public function __construct( array $route ) {
		parent::__construct( $route );
		$this->getLayoutEssentials();
	}

	protected function getLayoutEssentials() {
		switch ( $this->layout ) {
			case 'admin':
				break;
			case 'main':
			default:
				$categoryModel                         = new Category;
				$projectModel                          = new Project;
				$pageModel                             = new Page;
				$this->layoutEssentials ['categories'] = $categoryModel->findAllNames();
				$this->layoutEssentials ['projects']   = $projectModel->findAllNames();
				$this->layoutEssentials ['pages']      = $pageModel->findAllNames();
		}
	}
}
