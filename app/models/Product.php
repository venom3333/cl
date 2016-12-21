<?php
namespace app\models;

use core\base\Model;
use core\Error;

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
	 * @param string $sort критерий сортировки
	 * @param string $order критерий порядка сортировки
	 *
	 * @return array массив товаров определенной категории
	 */
	public function findByCategory( $categoryId, $sort = 'name', $order = 'ASC' ) {
		$sql = "SELECT * FROM {$this->table}
		JOIN product_has_category
    	ON product.id = product_has_category.product_id
		WHERE product_has_category.category_id = $categoryId
		AND product.status = 1
		ORDER BY $sort $order";

		return $this->pdo->query( $sql );
	}

	/**
	 * Получить определенный товар
	 *
	 * @param integer $id ID продукта
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
	 * @param integer $id продукта
	 *
	 * @return array массив изображений определенного товара
	 */
	protected function getImages( $id ) {
		$sql = "SELECT path AS image
		FROM product_image
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
		FROM specification
		WHERE product_id = $productId";

		return $this->pdo->query( $sql );
	}

	/**
	 * Получить количество спецификаций определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return integer количество спецификаций определенного товара
	 */
	protected function getSpecificationsCount( $productId ) {
		$sql = "
		SELECT count(*) as specs
		FROM specification
		WHERE product_id = $productId";

		$specs = $this->pdo->query( $sql );
		$specs = $specs[0]['specs'];

		return $specs;
	}

	/**
	 * Получить индекс всех товаров для админки
	 **
	 *
	 * @param string $sort критерий сортировки
	 * @param string $order критерий порядка сортировки
	 *
	 * @return array массив всех товаров для админки
	 */
	public function getProductsForAdmin( $sort = 'name', $order = 'ASC' ) {
		$products = $this->findAll( $sort, $order );

		foreach ( $products as &$product ) {
			$categories = $this->getCategories( $product['id'] );
			if ( $categories ) {
				$product['categories'] = $categories;
			}
			$specs = $this->getSpecificationsCount( $product['id'] );
			if ( $specs ) {
				$product['specs'] = $specs;
			}
		}

		return $products;
	}

	/**
	 * Получить категории определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @return array массив категорий определенного товара
	 */
	protected function getCategories( $productId ) {
		$sql = "
		SELECT `name`
		FROM category
  		JOIN product_has_category
    	ON category.id = product_has_category.category_id
		WHERE product_id = $productId
		ORDER BY name ASC";

		return $this->pdo->query( $sql );
	}

	/**
	 * Поменять статус видимости продукта на противоположный
	 *
	 * @param integer $productId ID продукта
	 *
	 */
	public function toggleStatus( int $productId ) {
		$sql = "
		SELECT status
		FROM {$this->table}
		WHERE id = $productId";

		$status = $this->pdo->query( $sql );
		$status = $status[0]['status'];

		if ( $status ) {
			$newStatus = 0;
		} else {
			$newStatus = 1;
		}

		$toggle = "
		UPDATE {$this->table}
		SET status = $newStatus
		WHERE id = $productId";

		$this->pdo->execute( $toggle );
	}

	/**
	 * Создет продукт (включая запись в базу и закачивание изобрбажений на сервер)
	 *
	 * @param array $product Массив с данными о продукте
	 *
	 * @return void
	 */
	public function createProduct( array $product ) {

		//d( $product );
		// записываем файл иконки на сервер
		if ( $product['icon']['error'] == 0 ) {
			$src            = $product['icon']['tmp_name'];
			$name           = $product['icon']['name'];
			$dest           = 'images/products/icons/';
			$uploadIconFile = $this->uploadAndResizeImage( $src, $name, $dest, 200, 150 );
		}

		// записываем в базу сам продукт
		$sql = "
		REPLACE INTO product
		SET name = '{$product['name']}',
    	status = '{$product['status']}',
    	short_description = '{$product['shortDescription']}',
    	description = '{$product['description']}',
    	icon = '/{$uploadIconFile}',
    	updated = NOW();
		";
		$this->pdo->execute( $sql );

		// читаем ID нового (обновленного) продукта
		$sql       = "
			SELECT id
			FROM product
			ORDER BY updated DESC
			LIMIT 1;
		";
		$productID = $this->pdo->query( $sql );
		$productID = $productID[0]['id'];

		// записываем изображения на сервер и в базу
		foreach ( $product['images'] as $image ) {
			if ( $image['error'] == 0 ) {
				$src  = $image['tmp_name'];
				$name = $image['name'];
				$dest = 'images/products/';
				$path = $this->uploadAndResizeImage( $src, $name, $dest );
			}
			$sql = "REPLACE INTO product_image
 					SET `product_id` = '$productID',
  					`path` = '/$path'
  					";

			$this->pdo->execute( $sql );
		}

		// записываем инфу о категориях
		foreach ( $product['categories'] as $category ) {
			$sql = "
		REPLACE INTO product_has_category
		SET product_id = '$productID',
			category_id = '$category'
		";
			$this->pdo->execute( $sql );
		}

		// записываем инфу о спецификациях
		foreach ( $product['specifications'] as $specification ) {
			if ( ! $specification['diameter'] ) {
				$specification['diameter'] = 0;
			}
			if ( ! $specification['length'] ) {
				$specification['length'] = 0;
			}
			if ( ! $specification['width'] ) {
				$specification['width'] = 0;
			}
			if ( ! $specification['height'] ) {
				$specification['height'] = 0;
			}
			if ( ! $specification['power'] ) {
				$specification['power'] = 0;
			}
			if ( ! $specification['light_output'] ) {
				$specification['light_output'] = 0;
			}
			if ( ! $specification['price'] ) {
				$specification['price'] = 0;
			}
			$sql = "
		REPLACE INTO specification
		SET product_id = '$productID',
			diameter = '{$specification['diameter']}',
			length = '{$specification['length']}',
			width = '{$specification['width']}',
			height = '{$specification['height']}',
			power = '{$specification['power']}',
			light_output = '{$specification['light_output']}',
			price = '{$specification['price']}'
		";
			$this->pdo->execute( $sql );
		}
	}

	/**
	 * Удаляет продукт (включая запись в базу и закачивание изобрбажений на сервер)
	 *
	 * @param integer $productId id удаляемого продукта
	 *
	 */
	public function removeProduct( int $productId ) {
		// Удаляем сам продукт
		// сначала файл-иконку
		$sql  = "
			SELECT icon
			FROM product
			WHERE id = $productId
		";
		$icon = $this->pdo->query( $sql );
		$icon = $icon[0];
		unlink( WWW . $icon['icon'] );

		// затем саму запись в БД
		$sql = "
			DELETE
			FROM product
			WHERE id = '$productId'
		";
		$this->pdo->execute( $sql );
		// Удаляем связанные с ним упоминания о принадлежности категорий
		$sql = "
			DELETE
			FROM product_has_category
			WHERE product_id = '$productId'
		";
		$this->pdo->execute( $sql );

		// Удаляем связанные с ним изображения
		// сначала сами файлы
		$sql    = "
			SELECT path
			FROM product_image
			WHERE product_id = '$productId'
		";
		$images = $this->pdo->query( $sql );
		foreach ( $images as $image ) {
			unlink( WWW . $image['path'] );
		}

		// Затем записи в БД
		$sql = "
			DELETE
			FROM product_image
			WHERE product_id = '$productId'
		";
		$this->pdo->execute( $sql );

		// Удаляем связанные с ним спецификации
		$sql = "
			DELETE
			FROM specification
			WHERE product_id = '$productId'
		";
		$this->pdo->execute( $sql );
	}
}