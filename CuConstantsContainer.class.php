<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 20:33
 *
 * Created by IntelliJ IDEA
 *
 * Filename: CuConstantsContainer.class.php
 */

namespace curlibrary;

/**
 * Class CuConstantsContainer
 */
class CuConstantsContainer {

	/**
	 * @var
	 */
	private $app_root_HTTP;
	/**
	 * @var
	 */
	private $app_root_Server;
	/**
	 * @var
	 */
	private $app_root_FQHTTP;
	/**
	 * @var
	 */
	private $file_path_HTTP;

	/**
	 * @var string
	 */
	private $server_serverName = '';
	/**
	 * @var string
	 */
	private $server_document_root = '';
	/**
	 * @var string
	 */
	private $server_phpSelf = '';
	/**
	 * @var string
	 */
	private $server_protocol = '';


	/**
	 *
	 */
	public function __construct() {
		$this->buildServerValues();

		$this->buildAppRootHTTP();
		$this->buildAppRootServer();
		$this->buildAppRootFQHTTP();
		$this->buildFilePathHTTP();
	}


	/**
	 * @param $path
	 *
	 * @return string
	 */
	public static function makeGoodPathServer($path) {
		$path = (string)$path;
		$path = str_replace(['\\', '/',], DIRECTORY_SEPARATOR, $path);

		return $path;
	}


	/**
	 * @param $path
	 *
	 * @return mixed
	 */
	public static function makeGoodPathHTTP($path) {
		$path = (string)$path;
		$path = str_replace('\\', '/', $path);

		return $path;
	}


	/**
	 * @return mixed
	 */
	public function get_file_path_HTTP() {
		return $this->file_path_HTTP;
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


	private function buildServerValues() {
		$this->server_serverName    = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
		$this->server_document_root = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';
		$this->server_phpSelf       = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
		$this->server_protocol      = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : '';
	}


	/**
	 *
	 */
	private function buildAppRootHTTP() {
		$doc_root = $this->server_document_root;
		$dirname  = __DIR__;

		$app_root = substr($dirname, strlen($doc_root));

		$app_root            = str_replace(['\\', 'inc/_close/_composer/vendor/computerundsound/culibrary',],
		                                   ['/', '',],
		                                   $app_root);
		$this->app_root_HTTP = $app_root;
	}


	/**
	 *
	 */
	private function buildAppRootServer() {
		$path                  = $this->server_document_root . $this->app_root_HTTP;
		$this->app_root_Server = self::makeGoodPathServer($path);
	}


	/**
	 *
	 */
	private function buildAppRootFQHTTP() {

		$methode = $this->server_protocol;
		$methode = substr($methode, 0, 4);
		$methode = strtoupper($methode);

		$protocol = 'http://';
		if($methode === 'HTTPS') {
			$protocol = 'https://';
		}

		$url = $protocol . $this->server_serverName;

		$app_root = $this->app_root_HTTP;

		$this->app_root_FQHTTP = $url . $app_root;
	}


	/**
	 *
	 */
	private function buildFilePathHTTP() {
		$this->buildAppRootHTTP();
		$file_path            = $this->app_root_FQHTTP . $this->server_phpSelf;
		$this->file_path_HTTP = $file_path;
	}
}