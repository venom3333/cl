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
		$sql = "SELECT `name`, `short_description` FROM {$this->table}
		WHERE id = $categoryId";

		return $this->pdo->query( $sql );
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
			FROM `custom_light`.category
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
			FROM `custom_light`.category
		 ' );
		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$cats = $result->fetchAll();

		$db = null; // закрыть соединение
		return $cats;
	}

	/**
	 * Получить товары для индекс страницы
	 *
	 * @return array массив товаров для индекс страницы
	 */
	public static function getIndexOfItems() {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT * FROM `custom_light`.item
	' );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$items = $result->fetchAll();

		foreach ( $items as &$item ) {
			$colors = self::getItemColors( $item['id'] );
			if ( $colors ) {
				$item['colors'] = $colors;
			}
			$categories = self::getItemCategories( $item['id'] );
			if ( $categories ) {
				$item['categories'] = $categories;
			}
		}
		unset( $item );

		$db = null; // закрыть соединение
		return $items;
	}

	/**
	 * Получить все товары
	 *
	 * @return array массив всех товаров
	 */
	public static function getAllItems() {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT * FROM `custom_light`.item
	' );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$items = $result->fetchAll();

		foreach ( $items as &$item ) {
			$colors = self::getItemColors( $item['id'] );
			if ( $colors ) {
				$item['colors'] = $colors;
			}
			$categories = self::getItemCategories( $item['id'] );
			if ( $categories ) {
				$item['categories'] = $categories;
			}
			$images = self::getItemImages( $item['id'] );
			if ( $images ) {
				$item['images'] = $images;
			}
		}
		unset( $item );

		$db = null; // закрыть соединение
		return $items;
	}

	/**
	 * Получить все цвета, относящиеся к товару
	 *
	 * @param integer $itemId ID товара
	 *
	 * @return array массив всех цветов товара
	 */
	public static function getItemColors( $itemId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT `name` AS `color`
		FROM `custom_light`.color
		JOIN item_has_color
		ON color.id = item_has_color.color_id
		WHERE item_has_color.item_id =' . $itemId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$colors = $result->fetchAll();

		$db = null; // закрыть соединение
		return $colors;
	}

	/**
	 * Получить все цвета, относящиеся к товару
	 *
	 * @param integer $itemId ID товара
	 *
	 * @return array массив всех категорий товара
	 */
	public static function getItemCategories( $itemId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT `name` AS `category`
		FROM `custom_light`.category
		JOIN item_has_category
		ON category.id = item_has_category.category_id
		WHERE item_has_category.item_id =' . $itemId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$colors = $result->fetchAll();

		$db = null; // закрыть соединение
		return $colors;
	}

	/**
	 * Получить все цвета, относящиеся к товару
	 *
	 * @param integer $itemId ID товара
	 *
	 * @return array массив всех изображений товара
	 */
	public static function getItemImages( $itemId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT `path` AS `image`
		FROM `custom_light`.image
		JOIN item_has_image
		ON image.id = item_has_image.image_id
		WHERE item_has_image.item_id =' . $itemId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$images = $result->fetchAll();

		$db = null; // закрыть соединение
		return $images;
	}

	/**
	 * Получить все цвета, относящиеся к товару
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
		FROM `custom_light`.category
		WHERE id =' . $categoryId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$categoryHeader = $result->fetch();

		$db = null; // закрыть соединение
		return $categoryHeader;
	}
}