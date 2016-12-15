<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 05.12.2016
 * Time: 16:09
 */

namespace core\base;


use core\Db;

abstract class Model {

	protected $pdo;
	protected $table;

	public function __construct() {
		$this->pdo = Db::instance();
	}

	public function query( $sql ) {
		return $this->pdo->execute( $sql );
	}

	public function findAll( $sort = null, $order = 'DESC' ) {
		$sql = "SELECT * FROM {$this->table}";
		if ( $sort ) {
			$sql .= " ORDER BY {$sort} {$order}";
		}

		return $this->pdo->query( $sql );
	}

	public function findAllNames( $sort = 'name', $order = 'ASC' ) {
		$sql = "SELECT `id`, `name` FROM $this->table";
		if ( $sort ) {
			$sql .= " ORDER BY {$sort} {$order}";
		}

		return $this->pdo->query( $sql );
	}

	public function findById( $id ) {
		$sql = "SELECT *
 				FROM $this->table
				WHERE id = $id";

		return $this->pdo->query( $sql );
	}

	/**
	 * Изменяет размеры изображения
	 *
	 * @param string $image путь до изображения
	 * @param integer $w_o ширина выходного изображения
	 * @param integer $h_o высота выходного изображения
	 *
	 * @return bool
	 */
	protected function resizeImage( $image, $w_o = 1280, $h_o = 1024 ) {
		if ( ( $w_o < 0 ) || ( $h_o < 0 ) ) {
			echo "Некорректные входные параметры";

			return false;
		}

		list( $w_i, $h_i, $type ) = getimagesize( $image ); // Получаем размеры и тип изображения (число)

		// Если раскомментировать, будут соблюдаться пропорции и изображение может получаться меньше чем запланировано
		/*
		if ( $w_i > $h_i ) {  // Проверка на пропорции
			$h_o = 0;
		} else {
			$w_o = 0;
		}
		*/

		$types = array( "", "gif", "jpeg", "png" ); // Массив с типами изображений
		$ext   = $types[ $type ]; // Зная "числовой" тип изображения, узнаём название типа
		if ( $ext ) {
			$func  = 'imagecreatefrom' . $ext; // Получаем название функции, соответствующую типу, для создания изображения
			$img_i = $func( $image ); // Создаём дескриптор для работы с исходным изображением
		} else {
			echo 'Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый
			return false;
		}
		/* Если указать только 1 параметр, то второй подстроится пропорционально */
		if ( ! $h_o ) {
			$h_o = $w_o / ( $w_i / $h_i );
		}
		if ( ! $w_o ) {
			$w_o = $h_o / ( $h_i / $w_i );
		}
		$img_o = imagecreatetruecolor( $w_o, $h_o ); // Создаём дескриптор для выходного изображения
		imagecopyresampled( $img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i ); // Переносим изображение из исходного в выходное, масштабируя его
		$func = 'image' . $ext; // Получаем функция для сохранения результата
		return $func( $img_o, $image ); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции
	}
}