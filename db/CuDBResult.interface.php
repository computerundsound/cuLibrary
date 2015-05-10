<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 31.07.14
 * Time: 14:48
 *
 * Created by IntelliJ IDEA
 *
 * Filename: CuDBiResult.php
 */

namespace culibrary\db;

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
}
