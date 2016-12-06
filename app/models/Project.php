<?php
namespace app\models;

use core\base\Model;
use core\Db;

/**
 * Модель для таблицы Проектов (project)
 */
class Project extends Model {

	public $table = 'project';

	/**
	 * Получить индекс проектов относящихся к определенной категории
	 *
	 * @param integer $categoryId ID категории продуктов
	 *
	 * @return array массив проектов относящихся к определенной категории
	 */
	public function findByCategory( $categoryId, $sort = 'name', $order = 'ASC' ) {
		$sql = "SELECT * FROM {$this->table}
		JOIN category_has_project
    	ON project.id = category_has_project.project_id
		WHERE category_has_project.category_id = $categoryId
		ORDER BY $sort $order";

		return $this->pdo->query( $sql );
	}

	/**
	 * Получить определенный проект
	 *
	 * @param integer $id ID продукта
	 *
	 * @return array массив с данными определенного проекта
	 */
	public function findById( $id ) {
		$project = parent::findById( $id );

		$project = $project[0];

		// добавляем изображения
		$images = self::getImages( $id );
		if ( $images ) {
			$project['images'] = $images;
		}

		return $project;
	}

	/**
	 * Получить изображения определенного проекта
	 *
	 * @param integer $id ID продукта
	 *
	 * @return array массив изображений определенного проекта
	 */
	public function getImages( $id ) {
		$sql = "
		SELECT path AS image
		FROM `custom_light`.project_image
		WHERE project_id = $id";

		return $this->pdo->query( $sql );
	}


	public static function getProject( $projectId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT *
		FROM `custom_light`.project
		WHERE id =' . $projectId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$project = $result->fetch();

		// добавляем изображения
		$images = self::getProjectImages( $projectId );
		if ( $images ) {
			$project['images'] = $images;
		}

		$db = null; // закрыть соединение
		return $project;
	}

	/**
	 * Получить индекс проектов относящихся к определенной категории
	 *
	 * @param integer $categoryId ID категории продуктов
	 *
	 * @return array массив проектов относящихся к определенной категории
	 */
	public static function getProjectNames() {
		$db = Db::getConnection();

		$result = $db->query( '
		SELECT id, name
		FROM `custom_light`.project
  		' );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$projectNames = $result->fetchAll();

		$db = null; // закрыть соединение
		return $projectNames;
	}
}