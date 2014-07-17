<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 17.07.14
 * Time: 12:38
 *
 * Created by IntelliJ IDEA
 *
 * Filename: CuReloadPreventer.php
 */

/**
 * Class CuReloadPreventer
 *
 *
 * Es wird ein Token in die Session geschrieben. Beim Aufruf der Seite muss der alte Token mitgeliefert werden - sonst werden keine Postdata gesendet
 *
 */
class CuReloadPreventer
{

	private $token_new;
	private $token_old;
	private $token_request;
	private $test_token = false;

	private static $vari_name = 'ReloadPreventer_tooken';


	public function __construct()
	{
		if(session_id() === false)
		{
			throw new Exception('You must have a SESSION');
		}

		$this->generate_tooken_new();
		$this->test_token();
		$this->save_new_token();

		if($this->test_token === false)
		{
			$this->kill_request();
		}

	}


	private function generate_tooken_new()
	{
		$this->token_new = time() . str_pad(rand(0, 9999), 4, 0);
	}


	private function get_old_token()
	{
		$this->token_old = $_SESSION['ReloadPreventer_tooken'];
	}


	private function get_request_token()
	{
		$this->token_request = CuNet::get_post(self::$vari_name);
	}


	private function check_tooken()
	{
		if($this->token_old === $this->token_new)
		{
			$this->test_token = true;
		}
	}


	private function save_new_token()
	{
		$_SESSION[self::$vari_name] = $this->token_new;
	}


	private function kill_request()
	{
		$_REQUEST = null;
	}


	/**
	 * @return mixed
	 */
	public function get_token_new()
	{
		return $this->token_new;

	}


	/**
	 * @return string
	 */
	public static function get_vari_name()
	{
		return self::$vari_name;
	}

}