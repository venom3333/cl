<?php
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
		$db     = Db::getConnection();
		$result = $db->query( '
		SELECT *
		FROM `custom_light`.project
  		JOIN category_has_project
    	ON project.id = category_has_project.project_id
		WHERE category_has_project.category_id =' . $categoryId );

		$result->setFetchMode( PDO::FETCH_ASSOC );
		$projects = $result->fetchAll();

		$db = null; // закрыть соединение
		return $projects;
	}
}