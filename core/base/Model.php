<?php

namespace core\base;


use core\Db;
use core\Error;
use core\Venom;

abstract class Model {

	protected $pdo;     // объект класса Db на основе pdo
	protected $table;   // используемая моделью таблица

	public function __construct() {
		$this->pdo = Db::instance(); // создает (присваивает) объект PDO
	}

//	public function query( $sql ) {
//		return $this->pdo->execute( $sql );
//	}


	/**
	 * Делает выборку всех данный из определенной таблицы
	 *
	 * @param string $sort индекс сортировки
	 * @param string $order порядок сортировки
	 *
	 * @return array Массив всех данных из определенной таблицы
	 */
	public function findAll( $sort = '', $order = 'DESC' ) {
		$sql = "SELECT * FROM {$this->table}";
		if ( $sort ) {
			$sql .= " ORDER BY {$sort} {$order}";
		}
		return $this->pdo->query( $sql );
	}

	/**
	 * Делает выборку всех ID и Name из определенной таблицы
	 *
	 * @param string $sort индекс сортировки
	 * @param string $order порядок сортировки
	 *
	 * @return array Массив всех данных с ID и Name из определенной таблицы
	 */
	public function findAllNames( $sort = 'name', $order = 'ASC' ) {
		$sql = "SELECT `id`, `name` FROM $this->table";
		if ( $sort ) {
			$sql .= " ORDER BY {$sort} {$order}";
		}

		return $this->pdo->query( $sql );
	}

	/**
	 * Делает выборку всех данных определенного ID из определенной таблицы
	 *
	 * @param int $id
	 *
	 * @return array Массив всех данных определенного ID из определенной таблицы
	 */
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


	/**
	 * Преобразует кириллические символы в строке в транслитерацию (латиницей),
	 * также удаляет все "неестественные" символы и приводит строку к нижнему регистру
	 *
	 * @param string $str входная строка
	 *
	 * @return string выходная строка
	 */
	protected function translit( string $str ) {
		//d($str);
		//$str = strip_tags( $str ); // убираем HTML-теги
		$str = str_replace( array( "\n", "\r" ), " ", $str ); // убираем перевод каретки
		$str = preg_replace( "/\s+/", '', $str ); // удаляем все пробелы
		$str = trim( $str ); // убираем пробелы в начале и конце строки
		$str = function_exists( 'mb_strtolower' ) ? mb_strtolower( $str ) : strtolower( $str ); // переводим строку в нижний регистр (иногда надо задать локаль)
		$str = strtr( $str, array(
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'д' => 'd',
			'е' => 'e',
			'ё' => 'e',
			'ж' => 'j',
			'з' => 'z',
			'и' => 'i',
			'й' => 'y',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'h',
			'ц' => 'c',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'shch',
			'ы' => 'y',
			'э' => 'e',
			'ю' => 'yu',
			'я' => 'ya',
			'ъ' => '',
			'ь' => ''
		) );
		$str = preg_replace( "/[^0-9a-z-_.]/i", "", $str ); // очищаем строку от недопустимых символов
		$str = str_replace( " ", "-", $str ); // заменяем пробелы знаком минус
		return $str; // возвращаем результат
	}

	/**
	 * Загружает изображение на сервер, переименовывает его до латинских символов и изменяет
	 * размер изображения до заданного
	 *
	 * @param string $src путь до временного файла (источник)
	 * @param string $name имя будущего файла
	 * @param string $dest путь до будущего файла (куда сохранять)
	 * @param int $width ширина конечного изображения
	 * @param int $height высота конечного изображения
	 *
	 * @return string   путь до конечного изображения
	 */
	protected function uploadAndResizeImage( string $src, string $name, string $dest = 'images/', int $width = 1024, int $height = 768 ) : string {
		$this->resizeImage( $src, $width, $height );
		$uploadedFile = $dest . $this->translit( basename( $name ) );

		// если нет такой директории, то создаем ее
		if ( ! is_dir( $dest ) ) {
			mkdir( $dest, 0777, true );
		}

		move_uploaded_file( $src, $uploadedFile );
		if ( ! is_file( $uploadedFile ) ) {
			Error::common( "Файл не загрузился! (Из $src в $dest" );
		}

		return $uploadedFile;
	}

	/**
	 * Удаляет директорию, предварительно удалив все файлы и вложенные директории из нее (если есть) рекурсивно
	 *
	 * @param $dir
	 */
	protected function removeDirectory( $dir ) {
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			foreach ( $objects as $object ) {
				if ( $object != "." && $object != ".." ) {
					if ( filetype( $dir . "/" . $object ) == "dir" ) {
						$this->removeDirectory( $dir . "/" . $object );
					} else {
						unlink( $dir . "/" . $object );
					}
				}
			}
			reset( $objects );
			rmdir( $dir );
		}
	}
}