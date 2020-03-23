<?php

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

namespace computerundsound\culibrary\db;

/**
 * Interface CuDB
 */
interface CuDB
{


    public function cuTruncateTab($tableName);

    public function cuDeleteOneDataSet($tableName, $idName, $idValue);

    public function cuDelete($tableName, $where);

    public function cuQuery($query);

    public function cuInsert($tableName, array $assocDataArray);

    public function cuUpdateOneDataSet($tableName, array $assocDataArray, $idName, $id);

    public function cuUpdate($tableName, array $assocDataArray, $where);

    public function cuSelectOneDataSet($tableName, $fieldName, $fieldValue);

    public function cuSelectAsArray($tableName,
                                    $where = '',
                                    $order = '',
                                    $limit = '');

    public function cuGetQuantityOfDataSets($tableName);

    public function cuGetColNamesFromTable($tableName);

    public function cuCloseConnection();

    public function cuGetFieldInfo($tableName, $fieldName);
}