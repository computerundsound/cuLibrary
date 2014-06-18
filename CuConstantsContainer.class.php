<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 18.06.2014
 * Time: 20:33
 *
 * Created by IntelliJ IDEA
 *
 * Filename: CuConstantsContainer.class.php
 */

/**
 * Class CuConstantsContainer
 */
class CuConstantsContainer {

	private $app_root_HTTP;
	private $app_root_Server;
	private $app_root_FQHTTP;


	private $from_app_root_to_this_file;

	public function __construct() {

		$this->buildAppRootServer();
		$this->buildAppRootHTTP();
		$this->buildAppRootFQHTTP();

	}


	private function buildAppRootServer() {
		$path = dirname(__FILE__) . '/../../../../../';
		$path = realpath($path);
		$this->app_root_Server = self::makeGoodPathServer($path);

	}

	private function buildAppRootHTTP() {
		$path = dirname(__FILE__) . '/../../../../../';
		$path = realpath($path);
		$this->app_root_HTTP= self::makeGoodPathServer($path);
	}

	private function buildAppRootFQHTTP() {

		$methode = $_SERVER['REQUEST_METHOD'];
		$methode = substr($methode, 0, 5);
		$methode = strtoupper($methode);

		if ($methode === 'HTTPS') {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}

		$url = $protocol . $_SERVER['SERVER_NAME'];
		$this->app_root_FQHTTP= strtolower($url);
	}

	public static function makeGoodPathServer($path) {

		return $path;
	}

	public static function makeGoodPathHTTP($path) {
		return $path;
	}




	/**
	 * @return mixed
	 */
	public function getAppRootHTTP() {
		return $this->app_root_HTTP;
	}

	/**
	 * @return mixed
	 */
	public function getAppRootFQHTTP() {
		return $this->app_root_FQHTTP;
	}

	/**
	 * @return mixed
	 */
	public function getAppRootServer() {
		return $this->app_root_Server;
	}
}