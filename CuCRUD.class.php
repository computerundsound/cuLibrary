<?php

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 12.02.14
 * Time: 17:26
 *
 * Created by PhpStorm
 *
 * Filename: CuCRUD.class.php
 */
class CuCRUD {

	public $idName;
	public $id;
	public $data_set;
	private $_tab;
	private $_dbObj_coo;


	/**
	 * @param       $tab_name
	 * @param CuDBi $dbi_coo
	 */
	public function __construct($tab_name, CuDBi $dbi_coo) {
		$this->_tab = $tab_name;
		$this->_dbObj_coo = $dbi_coo;
	}


	/**
	 * @param array $id field_name_in_DB => value
	 */
	public function loadFromDB(array $id) {

		$this->idName = key($id);
		$this->id = $id[$this->idName];
		$idName = $this->idName;
		$id = $this->id;
		$data_sets_array = $this->_dbObj_coo->selectAsArray($this->_tab, $idName . '="' . $id . '"');
		$this->data_set = $data_sets_array[0];
	}


	/**
	 * @return array
	 */
	public function insertInDB() {
		$dataArray = $this->data_set;
		if(null !== $this->idName) {
			unset($dataArray[$this->idName]);
		}

		$ret = $this->_dbObj_coo->insert($this->_tab, $dataArray);

		return $ret;
	}


	/**
	 * @return array
	 */
	public function updateInDB() {
		$dataArray = $this->data_set;
		unset($dataArray[$this->idName]);
		$where = $this->idName . '=' . $this->id;
		$ret = $this->_dbObj_coo->update($this->_tab, $dataArray, $where);

		return $ret;
	}


	/**
	 * @param      $field_name
	 * @param null $forWhat
	 *
	 * @return string
	 */
	public function getValue($field_name, $forWhat = null) {
		$val = $this->data_set[$field_name];

		switch($forWhat) {
			case'HTML':
				$val = CuString::stringFromDB2HTML($val);
				break;

			case'FROM':
				$val = CuString::stringFromDB2Form($val);
				break;

			default:
				/* No Changes */
				break;
		}

		return $val;
	}
}