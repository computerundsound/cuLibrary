<?php
/** @noinspection PhpUnused */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlResolve */
/** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

namespace computerundsound\culibrary\db\mysqli;

use computerundsound\culibrary\db\CuDB;
use computerundsound\culibrary\db\CuDBResult;
use Exception;
use mysqli;
use RuntimeException;


class CuDBi extends mysqli implements CuDB
{

    protected static ?mysqli $instance = null;

    /** @var  CuDBiResult */
    protected static CuDBiResult $cuDBiResult;

    /**
     * @throws Exception
     */
    public static function getInstance(
        CuDBiResult $cuDBiResult,
        string      $serverName,
        string      $username,
        string      $password,
        string      $dbName,
        string      $port = '',
        string      $socket = ''
    ): ?CuDBi
    {

        self::$cuDBiResult = $cuDBiResult;

        if ($port === '') {
            $port = ini_get('mysqli.default_port') ?? '';
        }

        if ($socket === '') {
            $socket = ini_get('mysqli.default_socket' ?? '');
        }

        if (self::$instance === null) {

            try {
                /** @noinspection PhpUsageOfSilenceOperatorInspection */
                self::$instance = @new static($serverName, $username, $password, $dbName, (int)$port, $socket);

                if (!self::$instance ||
                    ((self::$instance instanceof self) === false) ||
                    self::$instance->connect_errno > 0) {

                    $errorMessage = 'Error while connecting to Database';

                    if (self::$instance instanceof self) {
                        $errorMessage = self::$instance->connect_error;
                    }

                    throw new RuntimeException($errorMessage);

                }

            } catch (Exception $e) {

                echo file_get_contents(__DIR__ . '/../db_error.html');
                exit;

            }
        }

        return self::$instance;
    }

    public function cuInsert($tableName, array $assocDataArray): CuDBResult
    {

        $insert_string = '';
        foreach ($assocDataArray as $key => $val) {
            if (is_string($val) || is_numeric($val)) {
                $valEscaped    = $this->real_escape_string($val);
                $insert_string .= ' ' . $key . '= "' . $valEscaped . '", ';
            }
        }

        $insert_string = substr($insert_string, 0, -2);

        $q = 'INSERT INTO `%s` SET %s;';
        $q = sprintf($q, $tableName, $insert_string);

        return $this->cuQuery($q);
    }

    public function cuQuery(string $query): CuDBiResult
    {

        $result = $this->query($query);
        $id     = $this->insert_id;

        self::$cuDBiResult->setResult($result);
        self::$cuDBiResult->setLastInsertId($id);
        self::$cuDBiResult->setQuery($query);

        return self::$cuDBiResult;
    }

    public function cuUpdateOneDataSet(string $tableName, array $assocDataArray, string $idName, $id): CuDBResult
    {

        $where = "$idName = '$id' ";

        return $this->cuUpdate($tableName, $assocDataArray, $where);
    }

    public function cuUpdate(string $tableName, array $assocDataArray, string $where): CuDBResult
    {

        $updateStr = '';
        $where     = ' WHERE ' . $where;

        foreach ($assocDataArray as $key => $val) {
            $valEscaped = $this->real_escape_string($val);
            $updateStr  .= ' ' . $key . ' = "' . $valEscaped . '", ';
        }

        $updateStr = substr($updateStr, 0, -2);
        $q         = 'UPDATE ' . $tableName . ' SET ' . $updateStr . $where;

        return $this->cuQuery($q);
    }

    public function cuDeleteOneDataSet(string $tableName, string $idName, $idValue): void
    {

        $where = " $idName='$idValue' ";
        $this->cuDelete($tableName, $where);
    }

    public function cuDelete(string $tableName, string $where): CuDBResult
    {

        $result = null;
        $where  = trim($where);
        if ($where !== '') {

            $query = 'DELETE FROM `%s` WHERE %s';
            $query = sprintf($query, $tableName, $where);

            $result = $this->cuQuery($query);
        }

        return $result;
    }

    public function cuSelectOneDataSet(string $tableName, string $fieldName, $fieldValue): array
    {

        $where         = " $fieldName='$fieldValue' ";
        $dataSetsArray = $this->cuSelectAsArray($tableName, $where);

        $dataSetArray = null;
        if (array_key_exists(0, $dataSetsArray)) {
            $dataSetArray = $dataSetsArray[0];
        }

        return $dataSetArray;
    }


    public function cuSelectAsArray(string $tableName,
                                    string $where = '',
                                    string $order = '',
                                    string $limit = ''): array
    {

        $data_array = [];
        $where      = trim($where);
        $order      = trim($order);
        $limit      = trim($limit);
        if ($where !== '') {
            $where = ' WHERE ' . $where;
        }
        if ($order !== '') {
            $order = ' ORDER BY ' . $order;
        }
        if ($limit !== '') {
            $limit = ' LIMIT ' . $limit;
        }


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

    public function cuGetQuantityOfDataSets(string $tableName, string $where = ''): int
    {

        $q      = "SELECT * FROM `%s` $where;";
        $q      = sprintf($q, $tableName);
        $result = $this->query($q);

        return $result->num_rows;
    }

    public function cuGetColNamesFromTable(string $tableName): array
    {

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
    public function cuCloseConnection(): void
    {

        $this->close();
    }


    public function cuGetFieldInfo($tableName, $fieldName): object
    {

        $query  = 'SELECT `%s` FROM `%s`;';
        $query  = sprintf($query, $fieldName, $tableName);
        $result = $this->query($query);

        return $result->fetch_field_direct(0);
    }

    public function cuTruncateTab(string $tableName): void
    {

        $q = 'TRUNCATE `' . $tableName . '`';
        $this->query($q);
    }


    public function update_one_data_set(string $tab_name, array $data, $id, string $id_name): CuDBResult
    {

        $where = "$id_name = '$id' ";

        return $this->cuUpdate($tab_name, $data, $where);
    }

    protected function __clone()
    {
    }
}
