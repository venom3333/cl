<?php
namespace app\models;
use core\base\Model;
use core\Db;
/**
 * Модель для таблицы Продуктов (product)
 */
class Product extends Model {

	public $table = 'product';

	/**
	 * Получить индекс товаров определенной категории
	 *
	 * @param integer $categoryId ID категории продуктов
	 *
	 * @return array массив товаров определенной категории
	 */
	public function findByCategory( $categoryId, $sort = 'name', $order = 'ASC' ) {
		$sql = "SELECT * FROM {$this->table}
		JOIN product_has_category
    	ON product.id = product_has_category.product_id
		WHERE product_has_category.category_id = $categoryId
		ORDER BY $sort $order";

		return $this->pdo->query( $sql );
	}

	/**
	 * Получить определенный товар
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return array массив с данными определенного товара
	 */
	public static function getProduct( $productId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT *
		FROM `custom_light`.product
		WHERE id =' . $productId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$product = $result->fetch();

		// добавляем изображения
		$images = self::getProductImages( $productId );
		if ( $images ) {
			$product['images'] = $images;
		}

		// добавляем спецификации
		$specifications = self::getProductSpecifications( $productId );
		if ( $specifications ) {
			$product['specifications'] = $specifications;
		}

		$db = null; // закрыть соединение
		return $product;
	}

	/**
	 * Получить изображения определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return array массив изображений определенного товара
	 */
	public static function getProductImages( $productId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT path AS image
		FROM `custom_light`.product_image
		WHERE product_id =' . $productId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$images = $result->fetchAll();

		$db = null; // закрыть соединение
		return $images;
	}

	/**
	 * Получить спецификации определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return array массив спецификаций определенного товара
	 */
	public static function getProductSpecifications( $productId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT *
		FROM `custom_light`.specification
		WHERE product_id =' . $productId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$specifications = $result->fetchAll();

		$db = null; // закрыть соединение
		return $specifications;
	}
}