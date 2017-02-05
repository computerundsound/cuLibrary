<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:13 MEZ
 */

namespace computerundsound\culibrary\db\pdo;

use computerundsound\culibrary\db\CuDB;
use computerundsound\culibrary\db\CuDBResult;
use PDO;

/**
 * @author    Jörg Wrase
 * @copyright 2011
 */

/** @noinspection SingletonFactoryPatternViolationInspection */
class CuDBpdo extends PDO implements CuDB
{

    /**
     * @var CuDBResult
     */
    protected static $instance;
    /** @var  CuDBpdoResult */
    protected static $cuDBpdoResult;


    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $dbName
     *
     * @noinspection PhpHierarchyChecksInspection
     */
    public function __construct($host, $username, $password, $dbName) {

        if (self::$instance === null) {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;
            parent::__construct($dsn, $username, $password);
        }
    }


    /**
     * @param CuDBpdoResult $cuDBpdoResult
     * @param string        $serverName
     * @param string        $username
     * @param string        $password
     * @param string        $dbName
     *
     * @return CuDBpdo
     */
    public static function getInstance(
        CuDBpdoResult $cuDBpdoResult,
        $serverName,
        $username,
        $password,
        $dbName
    ) {

        self::$cuDBpdoResult = $cuDBpdoResult;

        if (self::$instance === null) {
            self::$instance = new static($serverName, $username, $password, $dbName);
        }

        return self::$instance;
    }

    /**
     * @param $tabName
     */
    public function truncateTAB($tabName) {

        $q = 'TRUNCATE ' . $tabName;
        $this->query($q);
    }

    /**
     * @param $tableName
     * @param $idName
     * @param $idValue
     */
    public function deleteOneDataSet($tableName, $idName, $idValue) {

        $where = " $idValue='$idName' ";
        $this->cuDelete($tableName, $where);
    }

    /****************************************************************************************/
    /****************************************************************************************/
    /****************************************************************************************/
    /****************************************************************************************/
    /****************************************************************************************/
    /****************************************************************************************/
    /****************************************************************************************/

    /**
     * @param $tableName
     * @param $where
     *
     * @return CuDBResult
     */
    public function cuDelete($tableName, $where) {

        $where = trim($where);

        $query = "DELETE FROM $tableName WHERE $where";
        $stmt  = $this->prepare($query);

        $stmt->execute();

        self::$cuDBpdoResult->setQuery($query);
        self::$cuDBpdoResult->setPdoStatement($stmt);

        return self::$cuDBpdoResult;
    }

    /**
     * @param $tableName
     * @param $fieldName
     * @param $fieldValue
     *
     * @return array
     *
     */
    public function selectOneDataSet($tableName, $fieldName, $fieldValue) {

        $where         = "`$fieldName` = '$fieldValue'";
        $dataSetsArray = $this->selectAsArray($tableName, $where);

        $dataSetArray = [];
        if (array_key_exists(0, $dataSetsArray)) {
            $dataSetArray = $dataSetsArray[0];
        }

        return $dataSetArray;
    }


    /**
     * @param string $tableName
     * @param string $where
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public function selectAsArray($tableName, $where = '', $order = '', $limit = '') {

        $where = trim($where);
        $order = trim($order);
        $limit = trim($limit);
        if ($where !== '') {
            $where = ' WHERE ' . $where;
        }
        if ($order !== '') {
            $order = ' ORDER BY ' . $order;
        }
        if ($limit !== '') {
            $limit = ' LIMIT ' . $limit;
        }

        $query = "SELECT * FROM `$tableName` $where $order $limit";
        $stmt  = $this->prepare($query);
        $stmt->execute();

        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultArray;
    }

    /**
     * @param       $tableName
     * @param array $data
     * @param       $fieldName
     * @param       $fieldValue
     *
     * @return \PDOStatement
     */
    public function updateOneDataSet($tableName, array $data, $fieldName, $fieldValue) {

        $where = "$fieldName = '$fieldValue' ";

        $statement = $this->cuUpdate($tableName, $data, $where);

        return $statement;
    }

    /**
     * @param       $tableName
     * @param array $dataArray
     * @param       $where
     *
     * @return \PDOStatement
     */
    public function cuUpdate($tableName, array $dataArray, $where = '') {

        $query = "UPDATE $tableName SET ";

        if ($where !== '') {
            $where = " WHERE $where";
        }

        $statement = $this->buildQueryStringAndBindParameters($query, $dataArray, $where);
        $statement->execute();

        return $statement;
    }

    /**
     * @param        $queryStartString
     * @param array  $dataArray
     * @param string $where
     *
     * @return \PDOStatement
     * @throws \InvalidArgumentException
     */
    protected function buildQueryStringAndBindParameters($queryStartString, array $dataArray, $where = '') {

        $valueQuery = $this->buildValueQuery($dataArray);

        $query = $queryStartString . $valueQuery;

        $statement = $this->prepare($query . $where);

        $i = 0;
        foreach ($dataArray as $key => $val) {

            $i++;
            $pdoParameterInfo = $this->getParameterInfo($val);

            $statement->bindValue($i, $val, $pdoParameterInfo);
        }

        return $statement;
    }

    /**
     * @param array $dataArray
     *
     * @return string
     */
    protected function buildValueQuery(array $dataArray) {

        $valueQuery = '';

        foreach ($dataArray as $key => $val) {
            $valueQuery .= "$key = ?,";
        }
        $valueQuery = substr($valueQuery, 0, -1);

        return $valueQuery;
    }

    /**
     * @param $val
     *
     * @return int|string
     * @throws \InvalidArgumentException
     */
    protected function getParameterInfo($val) {

        $pdoParameterInfo = gettype($val);

        switch ($pdoParameterInfo) {
            case'boolean':
                $pdoParameterInfo = PDO::PARAM_BOOL;
                break;
            case'integer':
                $pdoParameterInfo = PDO::PARAM_INT;
                break;
            case'double':
                /* TODO-Jörg Wrase: Wrong! */
                $pdoParameterInfo = PDO::PARAM_INT;
                break;
            case'string':
                $pdoParameterInfo = PDO::PARAM_STR;
                break;
            case 'NULL':
                $pdoParameterInfo = PDO::PARAM_NULL;
                break;
            default:
                throw new \InvalidArgumentException('Parameter can only be boolean, integer, double or string');
        }

        return $pdoParameterInfo;
    }

    /**
     * @param $tableName
     * @param $fieldName
     * @param $fieldValue
     *
     * @return array
     */
    public function selectOneDataEasySet($tableName, $fieldName, $fieldValue) {

        $where         = " $fieldName='$fieldValue' ";
        $dataSetsArray = $this->selectAsArray($tableName, $where);

        $dataSetArray = [];
        if (array_key_exists(0, $dataSetsArray)) {
            $dataSetArray = $dataSetsArray[0];
        }

        return $dataSetArray;
    }

    /**
     * @param $tableName
     * @param $where
     * @param $order
     * @param $limit
     *
     * @return CuDBResult
     */
    public function selectAsCuResult($tableName, $where = '', $order = '', $limit = '') {

        $where = trim($where);
        $order = trim($order);
        $limit = trim($limit);
        if ($where !== '') {
            $where = ' WHERE ' . $where;
        }
        if ($order !== '') {
            $order = ' ORDER BY ' . $order;
        }
        if ($limit !== '') {
            $limit = ' LIMIT ' . $limit;
        }

        $q = "SELECT * FROM `$tableName` $where $order $limit";

        $cuResult = $this->cuQuery($q);

        return $cuResult;
    }

    /**
     * @param $query
     *
     * @return CuDBResult
     */
    public function cuQuery($query) {

        $statement = $this->query($query);
        $id        = (int)$this->lastInsertId();

        if ($statement) {
            self::$cuDBpdoResult->setPdoStatement($statement);
        }

        self::$cuDBpdoResult->setLastInsertId($id);

        return self::$cuDBpdoResult;
    }

    /**
     * @param       $tableName
     * @param array $dataArray
     *
     * @return \PDOStatement
     */
    public function cuInsert($tableName, array $dataArray) {

        $insert_string = "INSERT INTO $tableName SET ";

        $statement = $this->buildQueryStringAndBindParameters($insert_string, $dataArray);
        $statement->execute();

        return $statement;
    }

    /**
     * @param        $tableName
     * @param string $where
     *
     * @return int
     */
    public function getQuantityOfDataSets($tableName, $where = '') {

        if ($where !== '') {
            $where = " WHERE $where";
        }
        $query = "SELECT count(*) as countDataSets FROM $tableName $where;";
        $stmt  = $this->query($query);

        return $stmt->fetchColumn(0);

    }

    /**
     *
     */
    public function closeConnection() {

        $this->closeConnection();
    }

    /**
     * @param $tableName
     *
     * @return array
     */
    public function getColNamesFromTable($tableName) {

        $query = 'DESCRIBE ' . $tableName;

        $stmt = $this->prepare($query);
        /* TODO-Jörg Wrase See IDE-Warning - for all ->execute(s) */
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);

    }

    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return object;
     */
    public function getFieldInfo($tableName, $fieldName) {
        // TODO: Implement getFieldInfo() method.
    }

    private function __clone() {
    }
}
