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
	 * Получить определенную категорию
	 *
	 * @param integer $id ID продукта
	 *
	 * @return array массив с данными определенного товара
	 */
	public function findById( $id ) {
		$category = parent::findById( $id );

		return $category[0];
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

		if ( ! $categoryId ) {
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

	/**
	 * Создет категорию (включая запись в базу и закачивание изобрбажений на сервер)
	 *
	 * @param array $category Массив с данными о категории
	 *
	 */
	public function createCategory( array $category ) {

		// записываем файл иконки на сервер
		if ( $category['icon']['error'] == 0 ) {
			$src            = $category['icon']['tmp_name'];
			$name           = $category['icon']['name'];
			$dest           = 'images/categories/icons/';
			$uploadIconFile = $this->uploadAndResizeImage( $src, $name, $dest, DEFAULT_ICON_WIDTH, DEFAULT_ICON_HEIGHT );
			//d($uploadIconFile);
		}
		// записываем в базу категорию
		$sql = "
		REPLACE INTO category
		SET name = '{$category['name']}',
    	short_description = '{$category['shortDescription']}',
    	description = '{$category['description']}',
    	icon = '/{$uploadIconFile}'
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Удаляет категорию (включая запись в базу и изобрбажения на сервере)
	 *
	 * @param integer $categoryId id удаляемой категории
	 *
	 */
	public function removeCategory( int $categoryId ) {
		// Удаляем категорию
		// сначала файл-иконку
		$sql  = "
			SELECT icon
			FROM category
			WHERE id = $categoryId
		";
		$icon = $this->pdo->query( $sql );
		$icon = $icon[0];
		unlink( WWW . $icon['icon'] );

		// затем саму запись в БД
		$sql = "
			DELETE
			FROM category
			WHERE id = '$categoryId'
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Сохраняет категорию поверх предыдущей (обновляет) (включая запись в базу и изобрбажения на сервере)
	 *
	 * @param integer $categoryId id перезаписываемой категории
	 * @param array $updatedCategory массив с информацией о категории
	 */
	public function updateCategory( int $categoryId, array $updatedCategory = [] ) {
		// если имеем новую иконку, то удаляем старую и записываем новую
		if ( ! $updatedCategory['icon']['error'] ) {

			// удаляем текущий файл-иконку
			$sql  = "
			SELECT icon
			FROM category
			WHERE id = $categoryId
		";
			$icon = $this->pdo->query( $sql );
			$icon = $icon[0];
			$file = WWW . $icon['icon'];
			if ( file_exists( $file ) ) {
				unlink( $file );
			}

			// записываем новый файл иконки на сервер
			$src                        = $updatedCategory['icon']['tmp_name'];
			$name                       = $updatedCategory['icon']['name'];
			$dest                       = 'images/categories/icons/';
			$updatedCategory['newIcon'] = $this->uploadAndResizeImage( $src, $name, $dest, DEFAULT_ICON_WIDTH, DEFAULT_ICON_HEIGHT );

			// пишем категорию в базу данных
			$sql = "
			UPDATE category
			SET name = '{$updatedCategory['name']}',
				short_description = '{$updatedCategory['short_description']}',
				description = '{$updatedCategory['description']}',
				icon = '/{$updatedCategory['newIcon']}'
				WHERE id = {$updatedCategory['id']}
			";

			$this->pdo->execute( $sql );

		} // иначе не трогаем картинки и пишем просто категорию в базу данных
		else {
			$sql = "
			UPDATE category
			SET name = '{$updatedCategory['name']}',
				short_description = '{$updatedCategory['short_description']}',
				description = '{$updatedCategory['description']}'
				WHERE id = {$updatedCategory['id']}
			";

			$this->pdo->execute( $sql );
		}
	}
}