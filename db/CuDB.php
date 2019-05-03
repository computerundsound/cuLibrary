<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:13 MEZ
 */

namespace computerundsound\culibrary\db;

/**
 * Interface CuDB
 */
interface CuDB
{

    /**
     * @param $tableName
     */
    public function cuTruncateTab($tableName);


    /**
     * @param $tableName
     * @param $idName
     * @param $idValue
     *
     */
    public function cuDeleteOneDataSet($tableName, $idName, $idValue);


    /**
     * @param $tableName
     * @param $where
     *
     * @return CuDBResult
     */
    public function cuDelete($tableName, $where);


    /**
     * @param $query
     *
     * @return CuDBResult
     */
    public function cuQuery($query);


    /**
     * @param       $tableName
     * @param array $assocDataArray
     *
     * @return CuDBResult
     */
    public function cuInsert($tableName, array $assocDataArray);


    /**
     * @param       $tableName
     * @param array $assocDataArray
     * @param       $idName
     * @param       $id
     *
     * @return CuDBResult
     */
    public function cuUpdateOneDataSet($tableName, array $assocDataArray, $idName, $id);


    /**
     * @param       $tableName
     * @param array $assocDataArray
     * @param       $where
     *
     * @return CuDBResult
     */
    public function cuUpdate($tableName, array $assocDataArray, $where);


    /**
     * @param $tableName
     * @param $fieldName
     * @param $fieldValue
     *
     * @return array
     */
    public function cuSelectOneDataSet($tableName, $fieldName, $fieldValue);


    /**
     * @param        $tableName
     * @param string $where
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public function cuSelectAsArray($tableName, $where = '', $order = '', $limit = '');


    /**
     * @param $tableName
     *
     * @return int
     */
    public function cuGetQuantityOfDataSets($tableName);


    /**
     * @param $tableName
     *
     * @return array
     */
    public function cuGetColNamesFromTable($tableName);


    /**
     *
     */
    public function cuCloseConnection();


    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return Object;
     */
    public function cuGetFieldInfo($tableName, $fieldName);
}