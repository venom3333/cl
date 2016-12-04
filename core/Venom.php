<?php
namespace core;
/**
 * Class Venom Вспомогательный класс фреймворка
 */
class Venom {

	/**
	 * Вывод шаблона на экран (вывод представления)
	 *
	 * @param \Smarty $smarty объект шаблонизатора
	 * @param string $templateName название файла шаблона
	 */
	public static function loadTemplate( $smarty, $templateName ) {
		$smarty->display( $templateName . TemplatePostfix );
	}

}