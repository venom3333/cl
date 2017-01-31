<?php
namespace app\models;

use core\base\Model;
use core\Venom;

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
			foreach ($specifications as &$specification) {
				foreach ($specification as &$field) {
					if($field == '0') $field = '-';         // Меняем на черточки для удобства отображения
				}
			}
			$product['specifications'] = $specifications;
		}

		// добавляем категории
		$categories = self::getCategories( $id );
		if ( $categories ) {
			$product['categories'] = $categories;
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
		$sql = "SELECT id, path AS image
		FROM product_image
		WHERE product_id = $id";

		return $this->pdo->query( $sql );
	}

	/**
	 * Получить спецификации определенного товара
	 *
	 * @param integer $productId ID продукта
	 *
	 * @param string $sort  критерий сортировки
	 * @param string $order порядок сортировки
	 *
	 * @return array массив спецификаций определенного товара
	 */
	protected function getSpecifications( $productId, $sort = 'diameter, length, price', $order = 'ASC' ) {
		$sql = "
		SELECT *
		FROM specification
		WHERE product_id = $productId
		ORDER BY $sort $order";

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
	public function getProductsForAdmin( $sort = 'id', $order = 'ASC' ) {
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
		SELECT id, `name`
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
		// записываем в базу сам продукт
		$product = Venom::addSlashes( $product ); //экранируем спецсимволы
		$sql = "
		REPLACE INTO product
		SET name = '{$product['name']}',
    	status = '{$product['status']}',
    	short_description = '{$product['shortDescription']}',
    	description = '{$product['description']}',
    	icon = '',
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

		// записываем файл иконки на сервер
		if ( $product['icon']['error'] == 0 ) {
			$src            = $product['icon']['tmp_name'];
			$name           = $product['icon']['name'];
			$dest           = "images/products/$productID/icons/";
			$uploadIconFile = $this->uploadAndResizeImage( $src, $name, $dest, DEFAULT_ICON_WIDTH, DEFAULT_ICON_HEIGHT );
			// записываем в базу путь до сохраненной иконки
			$sql = "
					UPDATE product
					SET icon = '/{$uploadIconFile}'
					WHERE id = $productID;
					";
			$this->pdo->execute( $sql );
		}

		// записываем изображения на сервер и в базу
		foreach ( $product['images'] as $image ) {
			if ( $image['error'] == 0 ) {
				$src  = $image['tmp_name'];
				$name = $image['name'];
				$dest = "images/products/$productID/";
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
		// саму запись из БД
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

		// Удаляем связанные с ним изображения (записи в БД)
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

		// Удаляем папку с изображениями
		$this->removeDirectory( "images/products/$productId/" );
	}

	/**
	 * Сохраняет основную информацию продукта поверх предыдущей (обновляет) (включая запись в базу и изобрбажение иконки на сервере)
	 *
	 * @param integer $productId id перезаписываемго продукта
	 * @param array $updatedProduct массив с информацией о продукте
	 */
	public function updateMain( int $productId, array $updatedProduct = [] ) {
		$updatedProduct = Venom::addSlashes( $updatedProduct ); //экранируем спецсимволы

		// если имеем новую иконку, то удаляем старую и записываем новую
		if ( ! $updatedProduct['icon']['error'] ) {
			// удаляем текущий файл-иконку
			$sql  = "
			SELECT icon
			FROM product
			WHERE id = $productId
		";
			$icon = $this->pdo->query( $sql );
			$icon = $icon[0];
			$file = WWW . $icon['icon'];
			if ( is_file( $file ) ) {
				unlink( $file );
			}

			// записываем новый файл иконки на сервер
			$src                       = $updatedProduct['icon']['tmp_name'];
			$name                      = $updatedProduct['icon']['name'];
			$dest                      = "images/products/$productId/icons/";
			$updatedProduct['newIcon'] = $this->uploadAndResizeImage( $src, $name, $dest, DEFAULT_ICON_WIDTH, DEFAULT_ICON_HEIGHT );

			// пишем информацию в базу данных
			$sql = "
			UPDATE product
			SET name = '{$updatedProduct['name']}',
				short_description = '{$updatedProduct['short_description']}',
				description = '{$updatedProduct['description']}',
				icon = '/{$updatedProduct['newIcon']}',
				updated = CURRENT_TIMESTAMP
				WHERE id = {$updatedProduct['id']}
			";

			$this->pdo->execute( $sql );

		} // иначе не трогаем картинки и просто пишем информацию в базу данных
		else {
			$sql = "
			UPDATE product
			SET name = '{$updatedProduct['name']}',
				short_description = '{$updatedProduct['short_description']}',
				description = '{$updatedProduct['description']}'
				WHERE id = {$updatedProduct['id']}
			";

			$this->pdo->execute( $sql );
		}
	}

	/**
	 * Обновляет информацию о категориях продукта
	 *
	 * @param integer $productId id продукта
	 * @param array $categories массив с информацией о категориях
	 */
	public function updateCategories( int $productId, array $categories = [] ) {
//		Удаляем старые записи о категориях
		$sql = "
			DELETE FROM product_has_category
			WHERE product_id = $productId
		";

		$this->pdo->execute( $sql );

//		Добавляем обновленные записи о категориях
		foreach ( $categories as $category ) {
			$sql = "
			INSERT INTO product_has_category
			SET product_id = $productId,
				category_id = $category
		";
			$this->pdo->execute( $sql );
		}
	}

	/**
	 * Добавляет изображение продукту и записывает его на сервер
	 *
	 * @param int $id ID продукта
	 * @param array $image массив с информацией о картинке
	 */
	public function addImage( int $id, array $image ) {
		// Добавляем файл на сервер
		$src          = $image['tmp_name'];
		$name         = $image['name'];
		$dest         = "images/products/$id";
		$newImagePath = $this->uploadAndResizeImage( $src, $name, $dest, IMAGE_WIDTH, IMAGE_HEIGHT );

		// Добавляем запись в БД
		$sql = "
			INSERT INTO product_image
			SET product_id = $id,
				path = '/$newImagePath'
		";

		$this->pdo->execute( $sql );
	}

	/**
	 * Удаляет определенное изображение у продукта и удаляет файл
	 *
	 * @param int $imageId ID изображения
	 */
	public function removeImage( int $imageId ) {
		// сначала файл
		$sql  = "
			SELECT path
			FROM product_image
			WHERE id = $imageId
		";
		$path = $this->pdo->query( $sql )[0];
		$file = WWW . $path['path'];
		if (is_file($file)){
			unlink($file);
		}
		// затем саму запись в БД
		$sql = "
			DELETE
			FROM product_image
			WHERE id = '$imageId'
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Добавляет спецификацию определенному продукту
	 *
	 * @param int $id ID продукта
	 * @param array $specification массив с информацией о спецификации
	 */
	public function addSpecification( int $id, array $specification ) {
		$sql = "
			INSERT INTO specification
			SET product_id = $id,
				diameter = {$specification['diameter']},
				length = {$specification['length']},
				width = {$specification['width']},
				height = {$specification['height']},
				power = {$specification['power']},
				light_output = {$specification['lightOutput']},
				price = {$specification['price']}
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Удаляет определенную спецификацию у продукта
	 *
	 * @param int $specificationId ID спецификации
	 */
	public function removeSpecification( int $specificationId ) {
		$sql = "
			DELETE FROM specification
			WHERE id = $specificationId
		";
		$this->pdo->execute( $sql );
	}
}