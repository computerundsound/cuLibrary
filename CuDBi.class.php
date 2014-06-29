<?php
/**
 * Copyright by Jörg Wrase - Computer-Und-Sound.de
 * Date: 20.12.13
 * Time: 12:14
 *
 * Created by PhpStorm
 *
 * Filename: CuDBi.class.php
 */

/**
 * Class CuDBi
 */
class CuDBi {

	/**
	 * @var string
	 */
	private $_dbName = '';

	/**
	 * @var string
	 */
	private $_server_name = '';
	/**
	 * @var string
	 */
	private $_username = '';
	/**
	 * @var string
	 */
	private $_password = '';

	/**
	 * @var
	 */
	private $_dbiConObj;
	/**
	 * @var
	 */
	private $mysql_link;


	/**
	 * @param string $server_name
	 * @param string $username
	 * @param string $password
	 * @param string $dbName
	 */
	public function __construct(/** @noinspection PhpUndefinedConstantInspection */
		$server_name = DB_SERVERNAME,
		$username = DB_USERNAME,
		$password = DB_PASSWORD,
		$dbName = DB_NAME
	) {

		$this->_server_name = $server_name;
		$this->_username = $username;
		$this->_password = $password;
		$this->_dbName = $dbName;

		try {
			if (!$dbConObj = new mysqli($this->_server_name, $this->_username, $this->_password, $this->_dbName)) {
				$dbError = $dbConObj->connect_errno;
				throw new Exception('Database not found - please check config-File');
			}
		} catch (Exception $e) {
			$message = $e->getMessage();

			if (isset($dbError)) {
				$message .= 'DB-Error-Code: ' . $dbError;
			}
			die($message);
		}

		$this->_dbiConObj = $dbConObj;
	}


	/**
	 * @param $tabName
	 */
	public function truncateTAB($tabName) {
		$q = 'TRUNCATE ' . $tabName;
		$this->$_dbiConObj->query($q);
	}

	/**
	 * @param $tab_name
	 * @param $where
	 */
	public function del($tab_name, $where) {
		$where = trim($where);
		if ($where !== '') {
			$where = 'WHERE ' . $where;
			$query = 'DELETE FROM ' . $tab_name . ' ' . $where;
			$this->query($query);
		}
	}

	/**
	 * @param $query
	 *
	 * @return array
	 */
	public function query($query) {
		$ret = array();
		$result = $this->_dbiConObj->query($query);
		$id = $this->_dbiConObj->insert_id;

		$ret['result'] = $result;
		$ret['insert_id'] = $id;

		return $ret;
	}

	/**
	 * @param string $tab_name
	 * @param array  $dataArray
	 *
	 * @return array array(result => bool, insert_id => int) / result is true or false
	 */
	public function insert($tab_name, array $dataArray) {
		$insert_string = '';
		foreach ($dataArray as $key => $val) {
			$val = $this->real_escape($val);
			$insert_string .= ' ' . $key . '= "' . $val . '", ';
		}

		$insert_string = substr($insert_string, 0, -2);
		$q = 'INSERT INTO ' . $tab_name . ' SET ' . $insert_string;
		$ret = $this->query($q);

		return $ret;
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public function real_escape($string) {
		if ($string) {
			$string = $this->_dbiConObj->real_escape_string($string);
		}

		return $string;
	}

	/**
	 * @param       $tab_name
	 * @param array $data
	 * @param       $where
	 *
	 * @return array
	 */
	public function update($tab_name, array $data, $where) {
		$updateStr = '';
		$where = ' WHERE ' . $where;

		foreach ($data as $key => $val) {
			$val = $this->real_escape($val);
			$updateStr .= ' ' . $key . ' = "' . $val . '", ';
		}

		$updateStr = substr($updateStr, 0, -2);
		$q = 'UPDATE ' . $tab_name . ' SET ' . $updateStr . $where;
		$ret = $this->query($q);

		return $ret;

	}

	/**
	 * @param string $tab_name
	 * @param string $where
	 * @param string $order
	 * @param string $limit
	 *
	 * @return array
	 */
	public function selectAsArray($tab_name, $where = '', $order = '', $limit = '') {
		$dbObj = $this->_dbiConObj;
		$data_array = array();
		$where = trim($where);
		$order = trim($order);
		$limit = trim($limit);
		if ($where === false) {
			$where = '';
		}
		if (!empty($where)) {
			$where = ' WHERE ' . $where;
		}
		if (!empty($order)) {
			$order = ' ORDER BY ' . $order;
		}
		if (!empty($limit)) {
			$limit = ' LIMIT ' . $limit;
		}

		$q = 'SELECT * FROM ' . $tab_name . $where . $order . $limit;
		$result = $dbObj->query($q);

		while ($data = $result->fetch_assoc()) {
			$data_array[] = $data;
		}

		return $data_array;
	}

	public function select_one_data_set($tab_name, $id, $id_name){
		$where = " $id_name='$id' ";
		$datasets_array = $this->selectAsArray($tab_name, $where);

		if (isset($datasets_array[0])) {
			$dataset_array = $datasets_array[0];
		} else {
			$dataset_array = false;
		}

		return $dataset_array;
	}

	/**
	 * @param $tab_name
	 *
	 * @return int
	 */
	public function get_quantity_of_data_sets($tab_name) {
		$dbObj = $this->_dbiConObj;
		$q = 'SELECT * FROM ' . $tab_name;
		$result = $dbObj->query($q);
		$data_sets_counts = $result->num_rows;

		return $data_sets_counts;
	}

	/**
	 * @param $tab_name
	 *
	 * @return array
	 */
	public function get_col_names_from_table($tab_name) {
		$db = $this->_dbiConObj;
		$sql = 'DESCRIBE ' . $tab_name;
		$result = $db->query($sql);
		$field_name = array();
		$data_array = array();
		while ($data = $result->fetch_assoc()) {
			$data_array[] = $data;
		};

		foreach ($data_array as $val) {
			array_push($field_name, $val['Field']);
		}

		return $field_name;

	}

	public function closeConnection() {
		$this->_dbiConObj->close();
	}


	/**
	 * @param mysqli_result $result
	 *
	 * @return array
	 */
	public function makeArrayFromResult(mysqli_result $result) {
		$data_sets_array = array();
		while (($data_array = $result->fetch_assoc()) != false) {
			$data_sets_array[] = $data_array;
		}

		return $data_sets_array;
	}


	public function delete($table, $where) {
		$sql = 'DELETE FROM ' . $table . ' ' . $where;

		$this->_dbiConObj->query($sql);

	}

	/**
	 * @return mysqli (db)
	 */
	public function getMysqlLink() {
		return $this->mysql_link;
	}

}

 