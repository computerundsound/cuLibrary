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


/**
 * Class CuDBiResult
 */
class CuDBiResult {

	private $result;
	private $last_insert_id;
	private $message;


	/**
	 * @return mixed
	 */
	public function get_last_insert_id()
	{
		return $this->last_insert_id;
	}


	/**
	 * @param mixed $last_insert_id
	 */
	public function set_last_insert_id($last_insert_id)
	{
		$this->last_insert_id = $last_insert_id;
	}


	/**
	 * @return mixed
	 */
	public function get_message()
	{
		return $this->message;
	}


	/**
	 * @param mixed $message
	 */
	public function set_message($message)
	{
		$this->message = $message;
	}


	/**
	 * @return mixed
	 */
	public function get_result()
	{
		return $this->result;
	}


	/**
	 * @param mixed $result
	 */
	public function set_result($result)
	{
		$this->result = $result;
	}



}
