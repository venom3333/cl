<?php

namespace app\controllers;


use app\models\Category;
use app\models\Project;
use app\models\Page;
use core\base\Controller;

abstract class AppController extends Controller {

	// Загружает необходимую информацию для определенного шаблона
	protected function getLayoutEssentials() {
		switch ( $this->layout ) {
			case 'admin':
				break;
			case 'main':
			case 'default':
				$categoryModel                         = new Category;
				$projectModel                          = new Project;
				$pageModel                             = new Page;
				$this->layoutEssentials ['categories'] = $categoryModel->findAllNames();
				$this->layoutEssentials ['projects']   = $projectModel->findAllNames();
				$this->layoutEssentials ['pages']      = $pageModel->findAllNames();
				break;
			default:
				break;
		}
	}
}
