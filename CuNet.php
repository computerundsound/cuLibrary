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

namespace computerundsound\culibrary;

/**
 * Class CuNet
 *
 * @package curlibrary
 */
class CuNet {

	/**
	 * @return array | 'client', referer', 'server', 'site', 'query',
	 */
	public static function getClientData() {
		$user_data_array = [];

		$ip                      = $_SERVER['REMOTE_ADDR'];
		$user_data_array['host'] = gethostbyaddr($ip);

		$user_data_array['ip'] = $ip;

		$userDataKeyValueArray = [
			'HTTP_USER_AGENT' => 'client',
			'HTTP_REFERER'    => 'referer',
			'SERVER_NAME'     => 'server',
			'PHP_SELF'        => 'site',
			'QUERY_STRING'    => 'query',
		];

		foreach($userDataKeyValueArray as $key => $val) {
			$user_data_array[$val] = '';
			if(isset($_SERVER[$key])) {
				$user_data_array[$val] = $_SERVER[$key];
			}
		}

		return $user_data_array;
	}


	/**
	 * @param $vari_name
	 * @param $standard_value
	 *
	 * @return bool|string
	 */
	public static function get_post_session_standard_value($vari_name, $standard_value) {

		if(!self::get_post_session($vari_name)) {
			$_SESSION[$vari_name] = $standard_value;

			return $standard_value;
		} else {
			return self::get_post_session($vari_name);
		}
	}


	/**
	 * @param $vari_name
	 *
	 * @return bool|string
	 */
	public static function get_post_session($vari_name) {
		$vari = false;

		if(isset($_SESSION[$vari_name])) {
			$vari = $_SESSION[$vari_name];
		}

		$pg_vari = self::get_post($vari_name);

		if($pg_vari !== false) {
			$vari                 = $pg_vari;
			$_SESSION[$vari_name] = $vari;
		}

		return $vari;
	}


	/**
	 * @param $vari_name
	 *
	 * @return string
	 */
	public static function get_post($vari_name) {
		$vari = false;

		if(isset($_GET[$vari_name])) {
			$vari = $_GET[$vari_name];
		}

		if(isset($_POST[$vari_name])) {
			$vari = $_POST[$vari_name];
		}

		$vari = self::strip_slashes_deep($vari);

		return $vari;
	}


	/**
	 *
	 * @param $value
	 *
	 * @return array|string
	 * will only do something when get_magic_quotes_gpc === true
	 */
	public static function strip_slashes_deep($value) {

		if(get_magic_quotes_gpc()) {
			$value = is_array($value) ? array_map([
				                                      __CLASS__,
				                                      'strip_slashes_deep',
			                                      ],
			                                      $value) : stripcslashes($value);
		}

		return $value;
	}
}
