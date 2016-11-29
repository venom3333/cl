<?php
/**
 *  Контроллер главной страницы
 */

// подключаем модели
include_once '../models/CategoryModel.php';

function testAction () {
	echo 'IndexController.php > testAction';
}

/**
 * Формирование главной страницы сайта
 *
 * @param Smarty $smarty шаблонизатор
 */
function indexAction(Smarty $smarty){
	$rsCategories = getMainCats();

	$rsItems = getAllItems();

	$smarty->assign('pageTitle', 'Главная страница сайта');
	$smarty->assign('categories', $rsCategories);
	$smarty->assign('items', $rsItems);

	//d($rsItems);

	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'index');
	loadTemplate($smarty, 'footer');
}