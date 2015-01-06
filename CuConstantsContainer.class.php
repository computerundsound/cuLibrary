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

/**
 * Class CuConstantsContainer
 */
class CuConstantsContainer
{

	private $app_root_HTTP;
	private $app_root_Server;
	private $app_root_FQHTTP;
	private $file_path_HTTP;


	/**
	 *
	 */
	public function __construct()
	{
		$this->buildAppRootHTTP();
		$this->buildAppRootServer();
		$this->buildAppRootFQHTTP();
		$this->buildFilePathHTTP();
	}


	/**
	 * @param $path
	 *
	 * @return mixed
	 */
	public static function makeGoodPathServer($path)
	{
		$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
		$path = str_replace('/', DIRECTORY_SEPARATOR, $path);

		return $path;
	}


	/**
	 * @param $path
	 *
	 * @return mixed
	 */
	public static function makeGoodPathHTTP($path)
	{
		$path = str_replace('\\', '/', $path);

		return $path;
	}

	/**
	 * @return mixed
	 */
	public function get_file_path_HTTP()
	{
		return $this->file_path_HTTP;
	}


	/**
	 *
	 */
	private function buildFilePathHTTP()
	{
		$this->buildAppRootHTTP();
		$file_path            = $this->app_root_FQHTTP . $_SERVER['PHP_SELF'];
		$this->file_path_HTTP = $file_path;
	}


	/**
	 * @return mixed
	 */
	public function getAppRootHTTP()
	{
		return $this->app_root_HTTP;
	}


	/**
	 * @return mixed
	 */
	public function getAppRootFQHTTP()
	{
		return $this->app_root_FQHTTP;
	}


	/**
	 * @return mixed
	 */
	public function getAppRootServer()
	{
		return $this->app_root_Server;
	}


	/**
	 *
	 */
	private function buildAppRootServer()
	{
		$path                  = $_SERVER['DOCUMENT_ROOT'] . $this->app_root_HTTP;
		$this->app_root_Server = self::makeGoodPathServer($path);
	}


	/**
	 *
	 */
	private function buildAppRootHTTP()
	{
		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		$dirname  = dirname(__FILE__);

		$app_root = substr($dirname, strlen($doc_root));

		$app_root            = str_replace('\\', '/', $app_root);
		$app_root            = str_replace('inc/_close/_composer/vendor/computerundsound/culibrary', '', $app_root);
		$this->app_root_HTTP = $app_root;

	}


	/**
	 *
	 */
	private function buildAppRootFQHTTP()
	{

		if (isset($_SERVER['SERVER_PROTOCOL']))
		{
			$methode = $_SERVER['SERVER_PROTOCOL'];
		}
		else
		{
			$methode = '';
		}
		$methode = substr($methode, 0, 4);
		$methode = strtoupper($methode);

		if ($methode === 'HTTPS')
		{
			$protocol = 'https://';
		}
		else
		{
			$protocol = 'http://';
		}

		$url = $protocol . $_SERVER['SERVER_NAME'];

		$app_root = $this->app_root_HTTP;

		$this->app_root_FQHTTP = $url . $app_root;
	}
}