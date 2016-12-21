<?php
namespace app\models;
use core\base\Model;
use core\Db;

/**
 * Модель для таблицы категорий (category)
 */
class Category extends Model {

	public $table = 'category';

	public function findCategoryBrief( $categoryId ) {
		$sql = "SELECT `name`, `short_description`, `description` FROM {$this->table}
		WHERE id = $categoryId";

		$categoryBrief = $this->pdo->query( $sql )[0];  // т.к. в результате только одна строка

		return $categoryBrief;
	}

	/**
	 * Получить дочерние категории для категории $catId
	 *
	 * @param integer $catId ID категории
	 *
	 * @return array массив дочерних категорий
	 */
	public static function getChildrenForCat( $catId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
			SELECT *
			FROM category
			WHERE parent_id =' . $catId );
		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$rs = $result->fetchAll();

		$db = null; // закрыть соединение
		return $rs;
	}

	/**
	 * Получить главные категории с привязками дочерних
	 *
	 * @return array массив всех категорий
	 */
	public static function getAllMainCatsWithChildren() {
		$rs = self::getMainCats();

		foreach ( $rs as &$r ) {
			$rsChildren = self::getChildrenForCat( $r['id'] );
			if ( $rsChildren ) {
				$r['children'] = $rsChildren;
			}
		}
		unset( $r );

		$db = null; // закрыть соединение
		return $rs;
	}

	/**
	 * Получить главные категории
	 *
	 * @return array массив главных категорий
	 */
	public static function getMainCats() {
		$db     = Db::getConnection();
		$result = $db->query( '
			SELECT *
			FROM category
		 ' );
		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$cats = $result->fetchAll();

		$db = null; // закрыть соединение
		return $cats;
	}

	/**
	 * Получить описание категории
	 *
	 * @param integer $categoryId ID категории
	 *
	 * @return array наименование категории
	 *
	 */
	public static function getCategoryHeader( $categoryId ) {

		if ( !$categoryId ) {
			$categoryHeader = [ 'name' => 'Все категории', 'short_description' => 'Продукция из всех категорий' ];

			return $categoryHeader;
		}

		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT name, short_description
		FROM category
		WHERE id =' . $categoryId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$categoryHeader = $result->fetch();

		$db = null; // закрыть соединение
		return $categoryHeader;
	}
}