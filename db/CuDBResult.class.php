<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 31.07.14
 * Time: 14:48
 *
 * Created by IntelliJ IDEA
 *
 * Filename: CuDBiResult.php
 */

namespace culibrary\db;

/**
 * Class CuDBResult
 */
class CuDBResult {


	/** @var  \PDOStatement */
	protected $pdoStatement;
	protected $result;
	protected $lastInsertId;
	protected $message;
	protected $query;


	/**
	 * @return mixed
	 */
	public function getLastInsertId() {
		return $this->lastInsertId;
	}


	/**
	 * @param $lastInsertId
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setLastInsertId($lastInsertId) {
		if(!is_int($lastInsertId)) {
			throw new \InvalidArgumentException('$lastInsertID must be an integer');
		}
		$this->lastInsertId = $lastInsertId;
	}


	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}


	/**
	 * @param string $message
	 */
	public function setMessage($message) {
		$message       = (string)$message;
		$this->message = $message;
	}


	/**
	 * @return \mysqli_result
	 */
	public function getResult() {
		return $this->result;
	}


	/**
	 * @param \mysqli_result $result
	 */
	public function setResult($result) {
		$this->result = $result;
	}


	/**
	 * @return string
	 */
	public function getQuery() {
		return $this->query;
	}


	/**
	 * @param string $query
	 */
	public function setQuery($query) {
		$query       = (string)$query;
		$this->query = $query;
	}


	/**
	 * @param \PDOStatement $pdoStatement
	 */
	public function setPdoStatement(\PDOStatement $pdoStatement) {
		$this->pdoStatement = $pdoStatement;
	}


	/**
	 * @return \PDOStatement
	 */
	public function getPdoStatement() {
		return $this->pdoStatement;
	}
}
