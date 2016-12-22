<?php
namespace core;
class Db {

	protected $pdo; // объект pdo
	protected static $instance; // сам объект Db
	public static $countSql = 0; // количество запросов за соединение
	public static $queries = []; // запросы за соединение

	// Создает объект PDO и присваивает его в одноименное поле
	protected function __construct() {
		require APP . '/config/db.php'; // конфигурация для БД
		$options   = [
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"         // !!!!!!!! НАДО !!!!!!!!
		];
		$this->pdo = new \PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, $options );
	}


	/**
	 * Проверяет не запущен ли уже экземпляр класса Db и если нет создает его
	 * @return Db Возвращает экземпляр класса Db
	 */
	public static function instance() {
		if ( self::$instance === null ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Выполняет запрос SQL
	 * @param string $sql запрос SQL
	 *
	 * @return bool true - все хорошо
	 */
	public function execute( $sql ) {
		self::$countSql ++;
		self::$queries[] = $sql;
		$stmt            = $this->pdo->prepare( $sql );

		return $stmt->execute();
	}

	/**
	 * Выполняет запрос SQL и возвращает выборку
	 * @param string $sql запрос SQL
	 *
	 * @return array возвращает массив с результатом выборки или пустой массив
	 */
	public function query( $sql ) {
		self::$countSql ++;
		self::$queries[] = $sql;
		$stmt = $this->pdo->prepare( $sql );
		$res  = $stmt->execute();
		if ( $res !== false ) {
			return $stmt->fetchAll();
		}
		return [];
	}
}