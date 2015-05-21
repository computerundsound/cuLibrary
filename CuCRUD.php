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

namespace computerundsound\culibrary;
use computerundsound\culibrary\db\mysqli\CuDBi;

/**
 * Class CuCRUD
 *
 * @package curlibrary
 */
class CuCRUD {

	public  $idName;
	public  $id;
	public  $data_set;
	private $_tab;
	private $_dbObj_coo;


	/**
	 * @param       $tableName
	 * @param CuDBi $dbi_coo
	 */
	public function __construct($tableName, CuDBi $dbi_coo) {
		$this->_tab       = $tableName;
		$this->_dbObj_coo = $dbi_coo;
	}


	/**
	 * @param array $id field_name_in_DB => value
	 */
	public function loadFromDB(array $id) {

		$this->idName    = key($id);
		$this->id        = $id[$this->idName];
		$idName          = $this->idName;
		$id              = $this->id;
		$data_sets_array = $this->_dbObj_coo->selectAsArray($this->_tab, $idName . '="' . $id . '"');
		$this->data_set  = $data_sets_array[0];
	}


	/**
	 * @return array
	 */
	public function insertInDB() {
		$dataArray = $this->data_set;
		if(null !== $this->idName) {
			unset($dataArray[$this->idName]);
		}

		$ret = $this->_dbObj_coo->cuInsert($this->_tab, $dataArray);

		return $ret;
	}


	/**
	 * @return array
	 */
	public function updateInDB() {
		$dataArray = $this->data_set;
		unset($dataArray[$this->idName]);
		$where = $this->idName . '=' . $this->id;
		$ret   = $this->_dbObj_coo->cuUpdate($this->_tab, $dataArray, $where);

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