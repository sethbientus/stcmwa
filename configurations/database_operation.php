<?php

/**
 * Database operation class
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/configurations/database_connection.php';
$connection = Connection::getInstance();
class Database_operation
{
	private $statement;
	public function store($query)
	{
		global $connection;
		$connect = $connection->getConnection();
		$this->statement = $connect->prepare($query);
		return $this->statement->execute();
	}
	public function getOneRow($query)
	{
		global $connection;
		$connect = $connection->getConnection();
		$this->statement = $connect->prepare($query);
		$this->statement->execute();
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}
	public function getMultipleRows($query)
	{
		global $connection;
		$connect = $connection->getConnection();
		$this->statement = $connect->prepare($query);
		$this->statement->execute();
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}
	public function update($query)
	{
		global $connection;
		$connect = $connection->getConnection();
		$this->statement = $connect->prepare($query);
		return $this->statement->execute();
	}
	public function delete($query)
	{
		global $connection;
		$connect = $connection->getConnection();
		$this->statement = $connect->prepare($query);
		$this->statement->execute();
		return $this->statement->rowCount();
	}
	public function escape_string($String)
	{
		global $connection;
		return $connection->escape_string($String);
	}
}
