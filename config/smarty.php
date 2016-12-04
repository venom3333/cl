<?php
//> Инициализация шаблонизатора Smarty
// put full path to Smarty.class.php
function getSmarty () {
	require( '../vendor/Smarty/libs/Smarty.class.php' );
	$smarty = new Smarty();

	$smarty->setTemplateDir( TemplatePrefix );
	$smarty->setCompileDir( '../tmp/smarty/templates_c' );
	$smarty->setCacheDir( '../tmp/smarty/cache' );
	$smarty->setConfigDir( '../tmp/smarty/configs' );

	$smarty->assign( 'templateWebPath', TemplateWebPath );

	return $smarty;
}
//<