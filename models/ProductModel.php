<?php

/**
 * Модель для таблицы Продуктов (category)
 */
class ProductModel {
	/**
	 * Получить индекс товаров определенной категории
	 *
	 * @param integer $categoryId ID категории продуктов
	 *
	 * @return array массив товаров определенной категории
	 */
	public static function getIndexOfProducts( $categoryId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT *
		FROM `custom_light`.product
  		JOIN product_has_category
    	ON product.id = product_has_category.product_id
		WHERE product_has_category.category_id =' . $categoryId );

		$result->setFetchMode( PDO::FETCH_ASSOC );
		$products = $result->fetchAll();

		$db = null; // закрыть соединение
		return $products;
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

		$result->setFetchMode( PDO::FETCH_ASSOC );
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

		$result->setFetchMode( PDO::FETCH_ASSOC );
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

		$result->setFetchMode( PDO::FETCH_ASSOC );
		$specifications = $result->fetchAll();

		$db = null; // закрыть соединение
		return $specifications;
	}
}