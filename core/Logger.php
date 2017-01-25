<?php
/**
 * Class Logger производит логгирование.
 * TODO: Сделать возможность логгирование не только в файл.
 */

namespace core;
// подключаем модели


class Logger {

	static private $_instance;
	private $path = ROOT."/logs/";
	private $file = "general.log";

	private function __construct() {
	}

	/**
	 * @param string $path
	 *
	 * @return Logger
	 */
	public function setPath( string $path ): Logger {
		$this->path = $path;

		return $this;
	}

	/**
	 * @param string $file
	 *
	 * @return Logger
	 */
	public function setFile( string $file ): Logger {
		$this->file = $file;

		return $this;
	}

	private function __clone() {
	}

	/**
	 * @return mixed
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new Logger();
		}

		return self::$_instance;
	}

	public function log( $msg ) {
		if ( ! $msg ) {
			$msg = "Пустое сообщение.";
		}
		$logData[] = date( 'd-m-Y H:i:s' ) . "  -->  " . $msg . PHP_EOL;

		if ( ! is_dir( $this->path ) ) {
			mkdir( $this->path );
		}

		file_put_contents( $this->path . date( 'd_m_Y' ) . "_" . $this->file, $logData, FILE_APPEND );
	}

}