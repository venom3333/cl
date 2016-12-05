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

	public function findAll() {
		$sql = "SELECT * FROM {$this->table}";

		return $this->pdo->query( $sql );
	}

}