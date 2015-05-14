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

namespace curlibrary;

/**
 * Class CuReloadPreventer
 *
 *
 * Es wird ein Token in die Session geschrieben. Beim Aufruf der Seite muss der alte Token mitgeliefert werden - sonst
 * werden keine PostData gesendet
 *
 */
class CuReloadPreventer {

	private static $vari_name = 'cu_reload_preventer';
	private        $token_new;
	private        $token_from_request;
	private        $token_from_session;
	private        $test_token_result;
	private        $switch_off;


	/**
	 * @param bool $switch_off
	 *
	 * @throws \curlibrary\RuntimeException
	 */
	public function __construct($switch_off = false) {
		if(session_id() === false) {
			throw new \RuntimeException('You must have a SESSION');
		}
		$this->switch_off = $switch_off;
		$this->load_token_from_request();
		$this->load_token_from_session();
		$this->generate_token_new();
		$this->check_token();
		$this->save_new_token();
	}


	/**
	 * @return string
	 */
	public static function get_vari_name() {
		return self::$vari_name;
	}


	public function test_and_kill_request() {

		if($this->test_token_result === false) {
			$this->kill_request();
		}
	}


	public function kill_request() {
		if($this->switch_off === false) {
			$_REQUEST = null;
			$_POST    = null;
			$_GET     = null;
			$_FILES   = null;
		}
	}


	/**
	 * @return mixed
	 */
	public function get_token_new() {
		return $this->token_new;
	}


	/**
	 * @return null
	 */
	public function get_test_token() {
		return $this->test_token_result;
	}


	private function load_token_from_request() {
		$this->token_from_request = CuNet::get_post(self::$vari_name);
	}


	private function load_token_from_session() {
		$this->token_from_session = false;
		if(isset($_SESSION[self::$vari_name])) {
			$this->token_from_session = $_SESSION[self::$vari_name];
		}
	}


	private function generate_token_new() {
		$this->token_new = time() . str_pad(rand(0, 9999), 4, 0);
	}


	private function check_token() {
		$this->test_token_result = false;
		if($this->token_from_session === $this->token_from_request) {
			$this->test_token_result = true;
		}
	}


	private function save_new_token() {
		$_SESSION[self::$vari_name] = $this->token_new;
	}
}