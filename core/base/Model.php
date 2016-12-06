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
}