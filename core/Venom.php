<?php
namespace core;
/**
 * Class Venom Вспомогательный класс фреймворка
 */
class Venom {

	/**
	 * Экранирование спецсимволов в строке или массиве строк
	 *
	 * @param array|string $data данные с экранированными символами в строках
	 *
	 * @return array|string
	 */
	public static function addSlashes( $data ) {
		$symbols = '"\';';
		if ( is_string( $data ) ) {
			$data = addcslashes( $data, $symbols );
		}
		if ( is_array( $data ) ) {
			foreach ( $data as &$str ) {
				if ( is_array( $str ) ) {
					$str = self::addSlashes( $str );
				}
				if ( is_string( $str ) ) {
					$str = addcslashes( $str, $symbols );
				}
			}
		}

		return $data;
	}
}