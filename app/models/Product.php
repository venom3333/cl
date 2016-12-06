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
	public function findById( $id ) {
		$product = parent::findById( $id );

		$product = $product[0];

		// добавляем изображения
		$images = self::getImages( $id );
		if ( $images ) {
			$product['images'] = $images;
		}

		// добавляем спецификации
		$specifications = self::getSpecifications( $id );
		if ( $specifications ) {
			$product['specifications'] = $specifications;
		}

		return $product;
	}

	/**
	 * Получить изображения определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return array массив изображений определенного товара
	 */
	protected function getImages( $id ) {
		$sql = "SELECT path AS image
		FROM `custom_light`.product_image
		WHERE product_id = $id";

		return $this->pdo->query( $sql );
	}

	/**
	 * Получить спецификации определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return array массив спецификаций определенного товара
	 */
	protected function getSpecifications( $productId ) {
		$sql = "
		SELECT *
		FROM `custom_light`.specification
		WHERE product_id = $productId";

		return $this->pdo->query( $sql );
	}
}