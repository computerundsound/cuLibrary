<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.19 at 01:47 MEZ
 */

namespace computerundsound\culibrary\db;

/**
 * Class CuDBResult
 */
interface CuDBResult {


	/**
	 * @return mixed
	 */
	public function getLastInsertId();


	/**
	 * @param mixed $lastInsertId
	 */
	public function setLastInsertId($lastInsertId);


	/**
	 * @return string
	 */
	public function getMessage();


	/**
	 * @param string $message
	 */
	public function setMessage($message);
	

	/**
	 * @return string
	 */
	public function getQuery();


	/**
	 * @param string $query
	 */
	public function setQuery($query);

    /**
     * @param $dbResult
     */
    public function setResult($dbResult);

    /**
     * @return mixed
     */
    public function getResult();
}
