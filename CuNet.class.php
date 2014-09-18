<?php

/**
 * Copyright by Jörg Wrase - Computer-Und-Sound.de
 * Date: 24.06.12
 * Time: 00:49
 *
 * Created by JetBrains PhpStorm
 *
 * Filename: CuNet.class.php
 */
class CuNet {

	/**
	 * @return bool | array (ip, host, client, referer, server, site, query)
	 *
	 */
	public static function getClientData() {
		$user_data_array = false;

		$ip = $_SERVER['REMOTE_ADDR'];

		//

		$user_data_array['host'] = gethostbyaddr($ip);

//		$ip = CuString::makeGoodIP($ip);

		$user_data_array['ip'] = $ip;

		$user_data_array['client'] = $_SERVER['HTTP_USER_AGENT'];
		$user_data_array['referer'] = $_SERVER['HTTP_REFERER'];
		$user_data_array['server'] = $_SERVER['SERVER_NAME'];
		$user_data_array['site'] = $_SERVER['PHP_SELF'];
		$user_data_array['query'] = $_SERVER['QUERY_STRING'];

		return $user_data_array;
	}


	/**
	 * @param $vari_name
	 *
	 * @return string
	 */
	public static function get_post($vari_name) {
		$vari = false;

		if (isset($_GET[$vari_name])) {
			$vari = $_GET[$vari_name];
		}

		if (isset($_POST[$vari_name])) {
			$vari = $_POST[$vari_name];
		}

		$vari = self::strip_slashes_deep($vari);

		return $vari;

	}


	/**
	 * @param $vari_name
	 *
	 * @return bool|string
	 */
	public static function get_post_session($vari_name) {
		$vari = false;

		if (isset($_SESSION[$vari_name])) {
			$vari = $_SESSION[$vari_name];
		}

		$pg_vari = self::get_post($vari_name);

		if ($pg_vari !== false) {
			$vari = $pg_vari;
			$_SESSION[$vari_name] = $vari;
		}

		return $vari;
	}


	/**
	 * @param $vari_name
	 * @param $standard_value
	 *
	 * @return bool|string
	 */
	public static function get_post_session_standard_value($vari_name, $standard_value) {

		if (!self::get_post_session($vari_name)) {
			$_SESSION[$vari_name] = $standard_value;

			return $standard_value;
		} else {
			return self::get_post_session($vari_name);
		}
	}


	/**
	 *
	 * @param $value
	 *
	 * @return array|string
	 * will only do something when get_magic_quotes_gpc === true
	 */
	public static function strip_slashes_deep($value) {

		if (get_magic_quotes_gpc()) {
			$value = is_array($value) ? array_map(array(
													  __CLASS__,
													  'strip_slashes_deep'
												  ),
												  $value) : stripcslashes($value);
		}

		return $value;
	}
}
