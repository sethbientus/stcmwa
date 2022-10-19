<?php

/**
 * Database connection class
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/configurations/configuration.php';
class Connection extends Configuration
{
	private static $instance = null;
	private $connect, $connected;

	function __construct()
	{
		try {
			$this->connect = new PDO("mysql:host=" . Configuration::server . ";dbname=" . Configuration::db, Configuration::user, Configuration::pwd, array(PDO::ATTR_PERSISTENT => true));
			$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
			echo "Failed to connect to the server " . $e->getMessage();
		}
	}
	public static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new Connection;
		}
		return self::$instance;
	}
	public function getConnection()
	{
		return $this->connect;
	}
	public function escape_string($string)
	{
		$this->connected = mysqli_connect(Configuration::server, Configuration::user, Configuration::pwd, Configuration::db);
		$escaped = $this->connected->real_escape_string($string);
		return $escaped;
	}
}
