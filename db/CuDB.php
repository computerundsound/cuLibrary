<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.20 at 02:44 MEZ
 */

namespace computerundsound\culibrary\db;

/**
 * Interface CuDB
 */
interface CuDB
{

    /**
     * @param $tableName
     *
     * @return \computerundsound\culibrary\db\mysqli\CuDBiResult
     */
    public function truncateTab($tableName);


    /**
     * @param $tableName
     * @param $idName
     * @param $idValue
     *
     * @return \computerundsound\culibrary\db\mysqli\CuDBiResult
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
     * @param string $tableName
     * @param string $where
     *
     * @return array
     * @internal param $fieldName
     * @internal param $fieldValue
     *
     */
    public function dataSetExist($tableName, $where = '');

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
     * @return mixed;
     */
    public function getFieldInfo($tableName, $fieldName);
}