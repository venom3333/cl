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
	$rsItems = getIndexOfItems();
	$rsBrands = getBrands();

	$smarty->assign('pageTitle', 'Custom Light. Нестандартное освещение');
	$smarty->assign('categories', $rsCategories);
	$smarty->assign('brands', $rsBrands);
	$smarty->assign('items', $rsItems);

	//d($rsItems);

	loadTemplate($smarty, 'index');
}