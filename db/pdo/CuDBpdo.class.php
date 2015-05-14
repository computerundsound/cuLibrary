<?php

/**
 * @author    Jörg Wrase
 * @copyright 2011
 */

namespace culibrary;

use culibrary\DB\CuDB;
use culibrary\db\CuDBResult;
use PDO;

/**
 * @author    Jörg Wrase
 * @copyright 2011
 */
class CuDBpdo extends PDO implements CuDB {


	/**
	 * @var CuDBResult
	 */
	private $cuDBResultTemplate;


	/**
	 * @param CuDBResult  $cuDBResultTemplate
	 * @param             $server
	 * @param             $dbName
	 * @param             $username
	 * @param             $password
	 * @param array       $options
	 */
	public function __construct(CuDBResult $cuDBResultTemplate,
	                            $server,
	                            $dbName,
	                            $username,
	                            $password,
	                            array $options = null) {

		$dsn = 'mysql:host=' . $server . ';dbname=' . $dbName;

		if($options === null) {
			$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
		}

		parent::__construct($dsn, $username, $password, $options);
		$this->cuDBResultTemplate = $cuDBResultTemplate;
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


	/**
	 * @param $tableName
	 * @param $where
	 *
	 * @return CuDBResult
	 */
	public function cuDelete($tableName, $where) {
		$where  = trim($where);
		$query  = "DELETE FROM `$tableName` WHERE $where";
		$result = $this->query($query);

		return $result;
	}


	/**
	 * @param $tableName
	 * @param $where
	 *
	 * @return array
	 */
	public function selectOneDataSet($tableName, $where) {

		$dataSetsArray = $this->selectAsArray($tableName, $where);

		$dataSetArray = [];
		if(array_key_exists(0, $dataSetsArray)) {
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
		if($where !== '') {
			$where = ' WHERE ' . $where;
		}
		if($order !== '') {
			$order = ' ORDER BY ' . $order;
		}
		if($limit !== '') {
			$limit = ' LIMIT ' . $limit;
		}

		$q = "SELECT * FROM `$tableName` $where $order $limit";

		$cuResult    = $this->cuQuery($q);
		$result      = $cuResult->getPdoStatement();
		$resultArray = $result->fetchAll(PDO::FETCH_ASSOC);

		return $resultArray;
	}

	//
	//	/**
	//	 * @param $string
	//	 *
	//	 * @return string
	//	 */
	//	public function real_escape($string) {
	//		if($string) {
	//			$string = $this->dbiConObj->real_escape_string($string);
	//		}
	//
	//		return $string;
	//	}
	//
	//

	/**
	 * @param $query
	 *
	 * @return CuDBResult
	 */
	public function cuQuery($query) {
		$statement = $this->query($query);
		$id        = (int)$this->lastInsertId();

		$cuDbResult = clone $this->cuDBResultTemplate;

		if($statement) {
			$cuDbResult->setPdoStatement($statement);
		}

		$cuDbResult->setLastInsertId($id);

		return $cuDbResult;
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
	 * @param       $tab_name
	 * @param array $dataArray
	 * @param       $where
	 *
	 * @return \PDOStatement
	 */
	public function cuUpdate($tab_name, array $dataArray, $where) {
		$where     = ' WHERE ' . $where;
		$updateStr = "UPDATE $tab_name";

		$statement = $this->buildQueryStringAndBindParameters($updateStr, $dataArray);
		$this->exec($statement->queryString . $where);

		return $statement;
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
		if(array_key_exists(0, $dataSetsArray)) {
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
		if($where !== '') {
			$where = ' WHERE ' . $where;
		}
		if($order !== '') {
			$order = ' ORDER BY ' . $order;
		}
		if($limit !== '') {
			$limit = ' LIMIT ' . $limit;
		}

		$q = "SELECT * FROM `$tableName` $where $order $limit";

		$cuResult = $this->cuQuery($q);

		return $cuResult;
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
	 * @param $tableName
	 *
	 * @return int
	 */
	public function getQuantityOfDataSets($tableName) {
		// TODO: Implement getQuantityOfDataSets() method.
	}


	/**
	 * @param $tableName
	 *
	 * @return array
	 */
	public function getColNamesFromTable($tableName) {
		// TODO: Implement getColNamesFromTable() method.
	}


	/**
	 *
	 */
	public function closeConnection() {
		// TODO: Implement closeConnection() method.
	}




	//
	//
	//	/**
	//	 * @param $tab_name
	//	 *
	//	 * @return int
	//	 */
	//	public function get_quantity_of_data_sets($tab_name) {
	//		$dbObj = $this->dbiConObj;
	//		$q = "SELECT * FROM `%s`;";
	//		$q = sprintf($q, $tab_name);
	//		$result = $dbObj->query($q);
	//		$data_sets_counts = $result->num_rows;
	//
	//		return $data_sets_counts;
	//	}
	//
	//
	//	/**
	//	 * @param $tab_name
	//	 *
	//	 * @return array
	//	 */
	//	public function get_col_names_from_table($tab_name) {
	//		$db = $this->dbiConObj;
	//		$sql = 'DESCRIBE ' . $tab_name;
	//		$result = $db->query($sql);
	//		$field_name = array();
	//		$data_array = array();
	//		while($data = $result->fetch_assoc()) {
	//			$data_array[] = $data;
	//		};
	//
	//		foreach($data_array as $val) {
	//			array_push($field_name, $val['Field']);
	//		}
	//
	//		return $field_name;
	//	}
	//
	//
	//	/**
	//	 *
	//	 */
	//	public function close_connection() {
	//		$this->dbiConObj->close();
	//	}
	//
	//
	//	/**
	//	 * @param mysqli_result $result
	//	 *
	//	 * @return array
	//	 */
	//	public function makeArrayFromResult(mysqli_result $result) {
	//		$data_sets_array = array();
	//		while(($data_array = $result->fetch_assoc()) != false) {
	//			$data_sets_array[] = $data_array;
	//		}
	//
	//		return $data_sets_array;
	//	}
	//
	//
	//	/**
	//	 * @param $tabname
	//	 * @param $fieldname
	//	 *
	//	 * @return object
	//	 */
	//	public function get_field_infos($tabname, $fieldname) {
	//		$query = "SELECT `%s` FROM `%s`;";
	//		$query = sprintf($query, $fieldname, $tabname);
	//		$result = $this->dbiConObj->query($query);
	//		$infos = $result->fetch_field_direct(0);
	//
	//		return $infos;
	//	}
	//
	//
	//	/**
	//	 * @return mysqli (db)
	//	 */
	//	public function getMysqlLink() {
	//		return $this->mysql_link;
	//	}


	/**
	 * @param $tableName
	 * @param $fieldName
	 *
	 * @return object;
	 */
	public function getFieldInfos($tableName, $fieldName) {
		// TODO: Implement getFieldInfos() method.
	}


	/**
	 * @param       $queryStartString
	 * @param array $dataArray
	 *
	 * @return \PDOStatement
	 */
	protected function buildQueryStringAndBindParameters($queryStartString, array $dataArray) {

		$valueQuery = $this->buildValueQuery($dataArray);

		$query = $queryStartString . $valueQuery;

		$statement = $this->prepare($query);

		$i = 0;
		foreach($dataArray as $key => $val) {

			$i++;
			$pdoParameterInfo = $this->getParameterInfo($val);

			//			$statement->bindParam($i, $val, $pdoParameterInfo);
			$statement->bindParam($i, $val, PDO::PARAM_STR);
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

		foreach($dataArray as $key => $val) {
			$valueQuery .= "$key = ?,";
		}
		$valueQuery = substr($valueQuery, 0, -1);

		return $valueQuery;
	}


	/**
	 * @param $val
	 *
	 * @return int|string
	 */
	protected function getParameterInfo($val) {
		$pdoParameterInfo = gettype($val);

		switch($pdoParameterInfo) {
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


	private function __clone() {
		// TODO: Implement __clone() method.
	}
}
