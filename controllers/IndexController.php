<?php
/**
 *  Контроллер главной страницы
 */

function testAction () {
	echo 'IndexController.php > testAction';
}

/**
 * Формирование главной страницы сайта
 *
 * @param Smarty $smarty шаблонизатор
 */
function indexAction(Smarty $smarty){
	$smarty->assign('pageTitle', 'Главная страница сайта');

	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'index');
	loadTemplate($smarty, 'footer');
}