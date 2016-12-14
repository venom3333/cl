<?php
/**
 * Class Error контроллер обработки ошибок
 */

namespace core;
// подключаем модели


class Error {

	/**
	 * Выводит страницу 404
	 *
	 * @param string $msg
	 */
	public static function e404( $msg = null ) {
		http_response_code( 404 );
		echo $msg;
		die;
	}

	/**
	 * Выводит текст ошибки и посылает код 400 Bad Request
	 *
	 * @param string $msg
	 */
	public static function common( $msg = null ) {
		http_response_code( 400 );
		echo $msg;
		die;
	}

}