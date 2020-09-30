<?php

/**
** Класс конфигурации базы данных
*/
class DB{

	const USER = "llerabie";
	const PASS = "Password123";
	const HOST = "localhost:3306";
	const DB   = "llerabie";

	public static function connToDB() {

		$user = self::USER;
		$pass = self::PASS;
		$host = self::HOST;
		$db   = self::DB;

		$conn = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
		return $conn;

	}
}
