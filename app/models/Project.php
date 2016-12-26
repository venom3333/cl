<?php
namespace app\models;

use core\base\Model;
use core\Error;
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

		// добавляем категории
		$categories = self::getCategories( $id );
		if ( $categories ) {
			$project['categories'] = $categories;
		}


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
		SELECT id, path AS image
		FROM project_image
		WHERE project_id = $id";

		return $this->pdo->query( $sql );
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
		FROM project
  		' );

		$result->setFetchMode( \PDO::FETCH_ASSOC );
		$projectNames = $result->fetchAll();

		$db = null; // закрыть соединение
		return $projectNames;
	}

	/**
	 * Получить индекс всех проектов для админки
	 **
	 *
	 * @param string $sort критерий сортировки
	 * @param string $order критерий порядка сортировки
	 *
	 * @return array массив всех проектов для админки
	 */
	public function getProjectsForAdmin( $sort = 'name', $order = 'ASC' ) {
		$projects = $this->findAll( $sort, $order );

		foreach ( $projects as &$project ) {
			$categories = $this->getCategories( $project['id'] );
			if ( $categories ) {
				$project['categories'] = $categories;
			}
		}

		return $projects;
	}

	/**
	 * Получить категории определенного проекта
	 *
	 * @param integer $projectId ID проекта
	 *
	 * @return array массив категорий определенного проекта
	 */
	protected function getCategories( $projectId ) {
		$sql = "
		SELECT id, `name`
		FROM category
  		JOIN category_has_project
    	ON category.id = category_has_project.category_id
		WHERE project_id = $projectId
		ORDER BY name ASC";

		return $this->pdo->query( $sql );
	}

	/**
	 * Создет проект (включая запись в базу и закачивание изобрбажений на сервер)
	 *
	 * @param array $project Массив с данными о проекте
	 *
	 */
	public function createProject( array $project ) {
		//d( $project );
		// записываем файл иконки на сервер
		if ( $project['icon']['error'] == 0 ) {
			$src            = $project['icon']['tmp_name'];
			$name           = $project['icon']['name'];
			$dest           = 'images/projects/icons/';
			$uploadIconFile = $this->uploadAndResizeImage( $src, $name, $dest, PROJECT_IMAGE_WIDTH, PROJECT_IMAGE_HEIGHT );
			//d($uploadIconFile);
		}
		// записываем в базу сам проект
		$sql = "
		REPLACE INTO project
		SET name = '{$project['name']}',
    	short_description = '{$project['shortDescription']}',
    	description = '{$project['description']}',
    	icon = '/{$uploadIconFile}'
		";
		$this->pdo->execute( $sql );

		// читаем ID нового (обновленного) проекта
		$sql       = "
			SELECT id
			FROM project
			ORDER BY id DESC
			LIMIT 1;
		";
		$projectID = $this->pdo->query( $sql );
		$projectID = $projectID[0]['id'];

		// записываем изображения на сервер и в базу
		foreach ( $project['images'] as $image ) {
			if ( $image['error'] == 0 ) {
				$src  = $image['tmp_name'];
				$name = $image['name'];
				$dest = "images/projects/";
				$path = $this->uploadAndResizeImage( $src, $name, $dest );
			}
			$sql = "REPLACE INTO project_image
 					SET `project_id` = '$projectID',
  					`path` = '/$path'
  					";
			//d($sql);

			$this->pdo->execute( $sql );
		}

		//d( $projectID );
		// записываем инфу о категориях
		foreach ( $project['categories'] as $category ) {
			$sql = "
		REPLACE INTO category_has_project
		SET project_id = '$projectID',
			category_id = '$category'
		";
			$this->pdo->execute( $sql );
		}
	}

	/**
	 * Удаляет проект (включая запись в базу и закачивание изобрбажений на сервер)
	 *
	 * @param integer $projectId id удаляемого проекта
	 *
	 */
	public function removeProject( int $projectId ) {
		// Удаляем сам продукт
		// сначала файл-иконку
		$sql  = "
			SELECT icon
			FROM project
			WHERE id = $projectId
		";
		$icon = $this->pdo->query( $sql );
		$icon = $icon[0];
		unlink( WWW . $icon['icon'] );

		// затем саму запись в БД
		$sql = "
			DELETE
			FROM project
			WHERE id = '$projectId'
		";
		$this->pdo->execute( $sql );
		// Удаляем связанные с ним упоминания о принадлежности категорий
		$sql = "
			DELETE
			FROM category_has_project
			WHERE project_id = '$projectId'
		";
		$this->pdo->execute( $sql );

		// Удаляем связанные с ним изображения
		// сначала сами файлы
		$sql    = "
			SELECT path
			FROM project_image
			WHERE project_id = '$projectId'
		";
		$images = $this->pdo->query( $sql );
		foreach ( $images as $image ) {
			unlink( WWW . $image['path'] );
		}

		// Затем записи в БД
		$sql = "
			DELETE
			FROM project_image
			WHERE project_id = '$projectId'
		";
		$this->pdo->execute( $sql );
	}

	/**
	 * Сохраняет основную информацию проекта поверх предыдущей (обновляет) (включая запись в базу и изобрбажение иконки на сервере)
	 *
	 * @param integer $projectId id перезаписываемго проекта
	 * @param array $updatedProject массив с информацией о проекте
	 */
	public function updateMain( int $projectId, array $updatedProject = [] ) {
		// если имеем новую иконку, то удаляем старую и записываем новую
		if ( ! $updatedProject['icon']['error'] ) {

			// удаляем текущий файл-иконку
			$sql  = "
			SELECT icon
			FROM project
			WHERE id = $projectId
		";
			$icon = $this->pdo->query( $sql );
			$icon = $icon[0];
			$file = WWW . $icon['icon'];
			if ( file_exists( $file ) ) {
				unlink( $file );
			}

			// записываем новый файл иконки на сервер
			$src                       = $updatedProject['icon']['tmp_name'];
			$name                      = $updatedProject['icon']['name'];
			$dest                      = 'images/projects/icons/';
			$updatedProject['newIcon'] = $this->uploadAndResizeImage( $src, $name, $dest, PROJECT_IMAGE_WIDTH, PROJECT_IMAGE_HEIGHT );

			// пишем информацию в базу данных
			$sql = "
			UPDATE project
			SET name = '{$updatedProject['name']}',
				short_description = '{$updatedProject['short_description']}',
				description = '{$updatedProject['description']}',
				icon = '/{$updatedProject['newIcon']}'
				WHERE id = {$updatedProject['id']}
			";

			$this->pdo->execute( $sql );

		} // иначе не трогаем картинки и просто пишем информацию в базу данных
		else {
			$sql = "
			UPDATE project
			SET name = '{$updatedProject['name']}',
				short_description = '{$updatedProject['short_description']}',
				description = '{$updatedProject['description']}'
				WHERE id = {$updatedProject['id']}
			";

			$this->pdo->execute( $sql );
		}
	}

	/**
	 * Обновляет информацию о категориях проекта
	 *
	 * @param integer $projectId id проекта
	 * @param array $categories массив с информацией о категориях
	 */
	public function updateCategories( int $projectId, array $categories = [] ) {
//		Удаляем старые записи о категориях
		$sql = "
			DELETE FROM category_has_project
			WHERE project_id = $projectId
		";

		$this->pdo->execute( $sql );

//		Добавляем обновленные записи о категориях
		foreach ( $categories as $category ) {
			$sql = "
			INSERT INTO category_has_project
			SET project_id = $projectId,
				category_id = $category
		";
			$this->pdo->execute( $sql );
		}
	}

	/**
	 * Добавляет изображение проекту и записывает его на сервер
	 *
	 * @param int $id ID проекта
	 * @param array $image массив с информацией о картинке
	 */
	public function addImage( int $id, array $image ) {
		// Добавляем файл на сервер
		$src          = $image['tmp_name'];
		$name         = $image['name'];
		$dest         = "images/projects/";
		$newImagePath = $this->uploadAndResizeImage( $src, $name, $dest, IMAGE_WIDTH, IMAGE_HEIGHT );

		// Добавляем запись в БД
		$sql = "
			INSERT INTO project_image
			SET project_id = $id,
				path = '/$newImagePath'
		";

		$this->pdo->execute( $sql );
	}

	/**
	 * Удаляет определенное изображение у проекта и удаляет файл
	 *
	 * @param int $imageId ID изображения
	 */
	public function removeImage( int $imageId ) {
		// сначала файл-иконку
		$sql  = "
			SELECT path
			FROM project_image
			WHERE id = $imageId
		";
		$path = $this->pdo->query( $sql )[0];
		unlink( WWW . $path['path'] );

		// затем саму запись в БД
		$sql = "
			DELETE
			FROM project_image
			WHERE id = '$imageId'
		";
		$this->pdo->execute( $sql );
	}
}