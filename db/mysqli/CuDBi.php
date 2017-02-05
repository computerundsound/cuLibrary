<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:13 MEZ
 */

namespace computerundsound\culibrary\db\mysqli;

use computerundsound\culibrary\db\CuDB;
use computerundsound\culibrary\db\CuDBResult;
use mysqli;

/**
 * Class CuDBi
 */
class CuDBi extends mysqli implements CuDB
{

    protected static $instance;
    /** @var  CuDBiResult */
    protected static $cuDBiResult;


    /**
     * @param CuDBiResult $cuDBiResult
     * @param string      $serverName
     * @param string      $username
     * @param string      $password
     * @param string      $dbName
     * @param string      $port
     * @param string      $socket
     *
     * @return mysqli | null
     */
    public static function getInstance(
        CuDBiResult $cuDBiResult,
        $serverName,
        $username,
        $password,
        $dbName,
        $port = null,
        $socket = null
    ) {

        self::$cuDBiResult = $cuDBiResult;

        if ($port === null) {
            $port = ini_get('mysqli.default_port');
        }

        if ($socket === null) {
            $socket = ini_get('mysqli.default_socket');
        }

        if (self::$instance === null) {

            try {
                /** @noinspection PhpUsageOfSilenceOperatorInspection */
                self::$instance = @new static($serverName, $username, $password, $dbName, $port, $socket);
            } catch (\Exception $e) {
                die('Can\'t connect to database');
            }
        }

        return self::$instance;
    }

    /**
     * @param string $tableName
     * @param array  $assocDataArray
     *
     * @return CuDBiResult
     */
    public function cuInsert($tableName, array $assocDataArray) {

        $insert_string = '';
        foreach ($assocDataArray as $key => $val) {
            $val           = $this->real_escape_string($val);
            $insert_string .= ' ' . $key . '= "' . $this->real_escape_string($val) . '", ';
        }

        $insert_string = substr($insert_string, 0, -2);
        /** @noinspection SqlNoDataSourceInspection */
        $q   = 'INSERT INTO `%s` SET %s;';
        $q   = sprintf($q, $tableName, $insert_string);
        $ret = $this->cuQuery($q);

        return $ret;
    }

    /**
     * @param $query
     *
     * @return CuDBiResult
     */
    public function cuQuery($query) {

        $result = $this->query($query);
        $id     = $this->insert_id;

        self::$cuDBiResult->setResult($result);
        self::$cuDBiResult->setLastInsertId($id);
        self::$cuDBiResult->setQuery($query);

        return self::$cuDBiResult;
    }

    /**
     * @param       $tableName
     * @param array $assocDataArray
     * @param       $idName
     * @param       $id
     *
     * @return CuDBResult
     */
    public function updateOneDataSet($tableName, array $assocDataArray, $idName, $id) {

        $where = "$idName = '$id' ";
        $ret   = $this->cuUpdate($tableName, $assocDataArray, $where);

        return $ret;
    }

    /**
     * @param       $tableName
     * @param array $assocDataArray
     * @param       $where
     *
     * @return CuDBResult
     */
    public function cuUpdate($tableName, array $assocDataArray, $where) {

        $updateStr = '';
        $where     = ' WHERE ' . $where;

        foreach ($assocDataArray as $key => $val) {
            $val       = $this->real_escape_string($val);
            $updateStr .= ' ' . $key . ' = "' . $val . '", ';
        }

        $updateStr = substr($updateStr, 0, -2);
        $q         = 'UPDATE ' . $tableName . ' SET ' . $updateStr . $where;
        $ret       = $this->cuQuery($q);

        return $ret;
    }

    /**
     * @param $tableName
     * @param $idName
     * @param $idValue
     */
    public function deleteOneDataSet($tableName, $idName, $idValue) {

        $where = " $idName='$idValue' ";
        $this->cuDelete($tableName, $where);
    }

    /**
     * @param $tableName
     * @param $where
     *
     * @return CuDBResult
     */
    public function cuDelete($tableName, $where) {

        $result = null;
        $where  = trim($where);
        if ($where !== '') {

            $query = 'DELETE FROM `%s` WHERE %s';
            $query = sprintf($query, $tableName, $where);

            $result = $this->cuQuery($query);
        }

        return $result;
    }

    /**
     * @param $tableName
     * @param $fieldName
     * @param $fieldValue
     *
     * @return array
     */
    public function selectOneDataSet($tableName, $fieldName, $fieldValue) {

        $where         = " $fieldName='$fieldValue' ";
        $dataSetsArray = $this->selectAsArray($tableName, $where);

        $dataSetArray = null;
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

        $data_array = [];
        $where      = trim($where);
        $order      = trim($order);
        $limit      = trim($limit);
        if ($where === false) {
            $where = '';
        }
        if ($where !== '') {
            $where = ' WHERE ' . $where;
        }
        if ($order !== '') {
            $order = ' ORDER BY ' . $order;
        }
        if ($limit !== '') {
            $limit = ' LIMIT ' . $limit;
        }

        /** @noinspection SqlNoDataSourceInspection */
        $q      = 'SELECT * FROM `%s` %s %s %s;';
        $q      = sprintf($q, $tableName, $where, $order, $limit);
        $result = $this->query($q);

        if ($result !== false) {
            while ($data = $result->fetch_assoc()) {
                $data_array[] = $data;
            }
        }

        return $data_array;
    }

    /**
     * @param string $tableName
     *
     * @param string $where
     *
     * @return int
     */
    public function getQuantityOfDataSets($tableName, $where = '') {

        $q                = "SELECT * FROM `%s` $where;";
        $q                = sprintf($q, $tableName);
        $result           = $this->query($q);
        $data_sets_counts = $result->num_rows;

        return $data_sets_counts;
    }

    /**
     * @param $tableName
     *
     * @return array
     */
    public function getColNamesFromTable($tableName) {

        $sql        = 'DESCRIBE ' . $tableName;
        $result     = $this->query($sql);
        $field_name = [];
        $data_array = [];
        while ($data = $result->fetch_assoc()) {
            $data_array[] = $data;
        }

        foreach ($data_array as $val) {
            $field_name[] = $val['Field'];
        }

        return $field_name;
    }

    /**
     *
     */
    public function closeConnection() {

        $this->close();
    }

    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return object;
     */
    public function getFieldInfo($tableName, $fieldName) {

        /** @noinspection SqlNoDataSourceInspection */
        $query  = 'SELECT `%s` FROM `%s`;';
        $query  = sprintf($query, $fieldName, $tableName);
        $result = $this->query($query);
        $info  = $result->fetch_field_direct(0);

        return $info;
    }

    /**
     * @param $tabName
     */
    public function truncateTAB($tabName) {

        $q = 'TRUNCATE ' . $tabName;
        $this->query($q);
    }

    /**
     * @param       $tab_name
     * @param array $data
     * @param       $id
     * @param       $id_name
     *
     * @return CuDBResult
     */
    public function update_one_data_set($tab_name, array $data, $id, $id_name) {

        $where = "$id_name = '$id' ";
        $ret   = $this->cuUpdate($tab_name, $data, $where);

        return $ret;
    }

    protected function __clone() {
    }
}
