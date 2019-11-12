<?php

namespace app\lib;

use PDO;

class Db
{
	public $db;
	protected static $_instance;

	private function __construct()
	{
		$config = require '../app/config/db.php';
		
        // Создаём объект PDO, передавая ему следующие переменные:   
		$this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . ';charset=' . $config['charset'], $config['user'], $config['password'], $config['opt']);		
	}
	
	// Singleton
	public static function getInstance()
	{

		if (self::$_instance === null)
			self::$_instance = new self;

		return self::$_instance;
	}

	private function __clone()
	{ }
	private function __wakeup()
	{ }
}
