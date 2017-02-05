<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2016.10.30 at 07:42 MEZ
 */

namespace computerundsound\culibrary\db\pdo;

use computerundsound\culibrary\db\CuDBResult;

/**
 * Class CuDBiResult
 */
class CuDBpdoResult implements CuDBResult
{

    /** @var  \PDOStatement */
    protected $pdoStatement;

    /** @var  \mysqli_result */
    private $result;

    private $lastInsertId;
    /** @var  string */
    private $message;
    /** @var  string */
    private $query;


    /**
     * @return int
     */
    public function getLastInsertId() {

        return $this->lastInsertId;
    }


    /**
     * @param mixed $lastInsertId
     */
    public function setLastInsertId($lastInsertId) {

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

        $this->message = (string)$message;
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
    public function setResult(\mysqli_result $result) {

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

        $this->query = (string)$query;
    }

    /**
     * @return \PDOStatement
     */
    public function getPdoStatement() {

        return $this->pdoStatement;
    }

    /**
     * @param \PDOStatement $pdoStatement
     */
    public function setPdoStatement(\PDOStatement $pdoStatement) {

        $this->pdoStatement = $pdoStatement;
    }


}
