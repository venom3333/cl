<?php

class Db {
	public static function getConnection()
	{
		include_once (ROOT . '/../config/db.php');
		$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		if(!$db) {
			echo "Ошибка доступа к базе данных";
			exit();
		}
		$db->exec('SET CHARACTER SET utf8');
		return $db;
	}
}