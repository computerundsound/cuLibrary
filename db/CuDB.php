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
    public function truncateTab($tableName);


    /**
     * @param $tableName
     * @param $idName
     * @param $idValue
     *
     */
    public function deleteOneDataSet($tableName, $idName, $idValue);


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
    public function updateOneDataSet($tableName, array $assocDataArray, $idName, $id);


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
    public function selectOneDataSet($tableName, $fieldName, $fieldValue);


    /**
     * @param        $tableName
     * @param string $where
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public function selectAsArray($tableName, $where = '', $order = '', $limit = '');


    /**
     * @param $tableName
     *
     * @return int
     */
    public function getQuantityOfDataSets($tableName);


    /**
     * @param $tableName
     *
     * @return array
     */
    public function getColNamesFromTable($tableName);


    /**
     *
     */
    public function closeConnection();


    /**
     * @param $tableName
     * @param $fieldName
     *
     * @return Object;
     */
    public function getFieldInfo($tableName, $fieldName);
}