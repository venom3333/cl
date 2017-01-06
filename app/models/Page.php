<?php

namespace app\models;

use core\base\Model;
use core\Venom;

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

	/**
	 * Создет страницу
	 *
	 * @param array $page Массив с данными о странице
	 *
	 */
	public function createPage( array $page ) {
		$page = Venom::addSlashes( $page ); //экранируем спецсимволы
		// записываем в базу страницу
		$sql = "
		REPLACE INTO page
		SET name = '{$page['name']}',
    	alias = '{$page['alias']}',
    	content = '{$page['content']}'
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Удаляет страницу
	 *
	 * @param integer $pageId id удаляемой станицы
	 *
	 */
	public function removePage( int $pageId ) {
		// Удаляем страницу
		$sql = "
			DELETE
			FROM page
			WHERE id = '$pageId'
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Сохраняет страницу поверх предыдущей (обновляет)
	 *
	 * @param integer $pageId id перезаписываемой категории
	 * @param array $updatedPage массив с информацией о категории
	 */
	public function updatePage( int $pageId, array $updatedPage = [] ) {
		$updatedPage = Venom::addSlashes( $updatedPage ); //экранируем спецсимволы
		// пишем страницу в базу данных
		$sql = "
			UPDATE page
			SET name = '{$updatedPage['name']}',
    		alias = '{$updatedPage['alias']}',
    		content = '{$updatedPage['content']}'
			WHERE id = '$pageId'
			";

		$this->pdo->execute( $sql );

	}
}