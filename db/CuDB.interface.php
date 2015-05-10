<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 10.05.2015
 * Time: 04:04
 * 
 * Created by IntelliJ IDEA
 *
 */

namespace culibrary\db;

/**
 * Interface CuDB
 */
interface CuDB {

	/**
	 * @param $server
	 * @param $username
	 * @param $password
	 * @param $dbName
	 *
	 * @return mixed
	 */
	//	public function getInstance($server, $username, $password, $dbName);

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
	 * @param $where
	 *
	 * @return array
	 */
	public function selectOneDataSet($tableName, $where);


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
	 * @return object;
	 */
	public function getFieldInfos($tableName, $fieldName);
}