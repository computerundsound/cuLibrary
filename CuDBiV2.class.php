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
class CuDBi
{

	/**
	 * @var string
	 */
	private $dbName = '';

	/**
	 * @var string
	 */
	private $server_name = '';
	/**
	 * @var string
	 */
	private $username = '';
	/**
	 * @var string
	 */
	private $password = '';


	/**
	 * @var mysqli
	 */
	private $dbiConObj;
	/**
	 * @var
	 */
	private $mysql_link;

	private $cu_dbi_result;


	/**
	 * @param CuDBiResult $cu_dbi_result
	 *
	 */
	public function __construct(/** @noinspection PhpUndefinedConstantInspection */

		CuDBiResult $cu_dbi_result
	)
	{

		$this->cu_dbi_result = $cu_dbi_result;

	}

	public function connect($server_name,
							$username,
							$password,
							$dbName) {

		$this->server_name   = $server_name;
		$this->username      = $username;
		$this->password      = $password;
		$this->dbName        = $dbName;

		try
		{
			if (!$dbConObj = new mysqli($this->server_name, $this->username, $this->password, $this->dbName))
			{
				$dbError = $dbConObj->connect_errno;
				throw new Exception('Database not found - please check config-File');
			}
		} catch (Exception $e)
		{
			$message = $e->getMessage();

			if (isset($dbError))
			{
				$message .= 'DB-Error-Code: ' . $dbError;
			}
			die($message);
		}

		$this->dbiConObj = $dbConObj;

	}


	/**
	 * @param $tabName
	 */
	public function truncateTAB($tabName)
	{
		$q = 'TRUNCATE ' . $tabName;
		$this->$_dbiConObj->query($q);
	}


	/**
	 * @param $tab_name
	 * @param $where
	 *
	 * @return CuDBiResult|null
	 */
	public function delete($tab_name, $where)
	{
		$result = null;
		$where = trim($where);
		if ($where !== '')
		{
			$query = "DELETE FROM `%s` WHERE %s";
			$query = sprintf($query, $tab_name, $where);

			$result = $this->query($query);
		}

		return $result;
	}

	/**
	 * @param $tabname
	 * @param $id
	 * @param $id_name
	 */
	public function delete_one_data_set($tabname, $id, $id_name)
	{
		$where = " $id_name='$id' ";
		$this->delete($tabname, $where);
	}


	/**
	 * @param $query
	 *
	 * @return CuDBiResult
	 */
	public function query($query)
	{
		$result = $this->dbiConObj->query($query);
		$id     = $this->dbiConObj->insert_id;

		$this->cu_dbi_result->set_result($result);
		$this->cu_dbi_result->set_last_insert_id($id);
		$this->cu_dbi_result->set_message('');
		$this->cu_dbi_result->setQuery($query);

		return $this->cu_dbi_result;
	}

	/**
	 * @param       $tab_name
	 * @param array $dataArray
	 *
	 * @return CuDBiResult
	 */
	public function insert($tab_name, array $dataArray)
	{
		$insert_string = '';
		foreach ($dataArray as $key => $val)
		{
			$val = $this->real_escape($val);
			$insert_string .= ' ' . $key . '= "' . $this->dbiConObj->real_escape_string($val) . '", ';
		}

		$insert_string = substr($insert_string, 0, -2);
		$q             = "INSERT INTO `%s` SET %s;";
		$q             = sprintf($q, $tab_name, $insert_string);
		$ret           = $this->query($q);

		return $ret;
	}


	/**
	 * @param $string
	 *
	 * @return string
	 */
	public function real_escape($string)
	{
		if ($string)
		{
			$string = $this->dbiConObj->real_escape_string($string);
		}

		return $string;
	}


	/**
	 * @param       $tab_name
	 * @param array $data
	 * @param       $where
	 *
	 * @return CuDBiResult
	 */
	public function update($tab_name, array $data, $where)
	{
		$updateStr = '';
		$where     = ' WHERE ' . $where;

		foreach ($data as $key => $val)
		{
			$val = $this->real_escape($val);
			$updateStr .= ' ' . $key . ' = "' . $val . '", ';
		}

		$updateStr = substr($updateStr, 0, -2);
		$q         = 'UPDATE ' . $tab_name . ' SET ' . $updateStr . $where;
		$ret       = $this->query($q);

		return $ret;

	}


	/**
	 * @param       $tab_name
	 * @param array $data
	 * @param       $id
	 * @param       $id_name
	 *
	 * @return CuDBiResult
	 */
	public function update_one_data_set($tab_name, array $data, $id, $id_name)
	{
		$where = "$id_name = '$id' ";
		$ret   = $this->update($tab_name, $data, $where);

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
	public function selectAsArray($tab_name, $where = '', $order = '', $limit = '')
	{
		$dbObj      = $this->dbiConObj;
		$data_array = array();
		$where      = trim($where);
		$order      = trim($order);
		$limit      = trim($limit);
		if ($where === false)
		{
			$where = '';
		}
		if (!empty($where))
		{
			$where = ' WHERE ' . $where;
		}
		if (!empty($order))
		{
			$order = ' ORDER BY ' . $order;
		}
		if (!empty($limit))
		{
			$limit = ' LIMIT ' . $limit;
		}

		$q      = "SELECT * FROM `%s` %s %s %s;";
		$q      = sprintf($q, $tab_name, $where, $order, $limit);
		$result = $dbObj->query($q);

		if ($result !== false)
		{
			while ($data = $result->fetch_assoc())
			{
				$data_array[] = $data;
			}
		}

		return $data_array;
	}


	/**
	 * @param $tab_name
	 * @param $fieldvalue
	 * @param $fieldname
	 *
	 * @return array
	 */
	public function select_one_data_set($tab_name, $fieldvalue, $fieldname)
	{
		$where          = " $fieldname='$fieldvalue' ";
		$datasets_array = $this->selectAsArray($tab_name, $where);

		if (isset($datasets_array[0]))
		{
			$dataset_array = $datasets_array[0];
		}
		else
		{
			$dataset_array = null;
		}

		return $dataset_array;
	}


	/**
	 * @param $tab_name
	 *
	 * @return int
	 */
	public function get_quantity_of_data_sets($tab_name)
	{
		$dbObj            = $this->dbiConObj;
		$q                = "SELECT * FROM `%s`;";
		$q                = sprintf($q, $tab_name);
		$result           = $dbObj->query($q);
		$data_sets_counts = $result->num_rows;

		return $data_sets_counts;
	}


	/**
	 * @param $tab_name
	 *
	 * @return array
	 */
	public function get_col_names_from_table($tab_name)
	{
		$db         = $this->dbiConObj;
		$sql        = 'DESCRIBE ' . $tab_name;
		$result     = $db->query($sql);
		$field_name = array();
		$data_array = array();
		while ($data = $result->fetch_assoc())
		{
			$data_array[] = $data;
		};

		foreach ($data_array as $val)
		{
			array_push($field_name, $val['Field']);
		}

		return $field_name;

	}


	/**
	 *
	 */
	public function close_connection()
	{
		$this->dbiConObj->close();
	}


	/**
	 * @param mysqli_result $result
	 *
	 * @return array
	 */
	public function makeArrayFromResult(mysqli_result $result)
	{
		$data_sets_array = array();
		while (($data_array = $result->fetch_assoc()) != false)
		{
			$data_sets_array[] = $data_array;
		}

		return $data_sets_array;
	}


	/**
	 * @param $tabname
	 * @param $fieldname
	 *
	 * @return object
	 */
	public function get_field_infos($tabname, $fieldname)
	{
		$query  = "SELECT `%s` FROM `%s`;";
		$query  = sprintf($query, $fieldname, $tabname);
		$result = $this->dbiConObj->query($query);
		$infos  = $result->fetch_field_direct(0);

		return $infos;
	}


	/**
	 * @return mysqli (db)
	 */
	public function getMysqlLink()
	{
		return $this->mysql_link;
	}

}

 