<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 03.01.2017
 * Time: 11:49
 */

namespace app\models;


use core\base\Model;

class Page extends Model {

	public $table = 'page';

	/**
	 * Делает выборку определенной страницы из определенной таблицы
	 *
	 * @param string $alias алиас страницы
	 *
	 * @return array Массив всех данных определенной страницы
	 */
	public function findByAlias( $alias ) {
		$sql = "
				SELECT * FROM $this->table
				WHERE alias = '$alias'
		";

		$page = $this->pdo->query( $sql );

		return $page[0];
	}

	/**
	 * Делает выборку ID, alias и name всех страниц из определенной таблицы
	 *
	 * @param string $alias алиас страницы
	 *
	 * @param string $sort индекс сортировки
	 * @param string $order порядок сортировки
	 *
	 * @return array Массив всех данных с ID, alias и Name из определенной таблицы
	 */
	public function findAllNames( $sort = 'id', $order = 'ASC' ) {
		$sql = "SELECT `id`, `alias`, `name` FROM $this->table";
		if ( $sort ) {
			$sql .= " ORDER BY {$sort} {$order}";
		}

		return $this->pdo->query( $sql );
	}

}