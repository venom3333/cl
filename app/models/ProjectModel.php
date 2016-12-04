<?php
namespace app\models;
use core\Db;
/**
 * Модель для таблицы Проектов (category)
 */
class ProjectModel {
	/**
	 * Получить индекс проектов относящихся к определенной категории
	 *
	 * @param integer $categoryId ID категории продуктов
	 *
	 * @return array массив проектов относящихся к определенной категории
	 */
	public static function getProjectsByCategory( $categoryId ) {
		$db = Db::getConnection();

		if ( ! $categoryId ) {
			$result = $db->query( '
		SELECT *
		FROM `custom_light`.project
  		LIMIT 4' );
		} else {
			$result = $db->query( '
		SELECT *
		FROM `custom_light`.project
  		JOIN category_has_project
    	ON project.id = category_has_project.project_id
		WHERE category_has_project.category_id =' . $categoryId );
		}
		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$projects = $result->fetchAll();

		$db = null; // закрыть соединение
		return $projects;
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

	/**
	 * Получить определенный проект
	 *
	 * @param integer $projectId ID продукта
	 *
	 * @return array массив с данными определенного проекта
	 */
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
	 * Получить изображения определенного проекта
	 *
	 * @param integer $projectId ID продукта
	 *
	 * @return array массив изображений определенного проекта
	 */
	public static function getProjectImages( $projectId ) {
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT path AS image
		FROM `custom_light`.project_image
		WHERE project_id =' . $projectId );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$images = $result->fetchAll();

		$db = null; // закрыть соединение
		return $images;
	}
}