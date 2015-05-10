<?php

/**
 * Copyright by Jörg Wrase - Computer-Und-Sound.de
 * Date: 24.06.12
 * Time: 00:39
 *
 * Created by JetBrains PhpStorm
 *
 * Filename: CuString.class.php
 */

namespace curlibrary;

/**
 * Class CuString
 *
 * @package curlibrary
 */
class CuString {

	/**
	 *
	 */
	public function __construct() {
	}


	/**
	 * @param $sessionVariable
	 * @param $expected_value
	 *
	 * @return bool
	 */
	public static function getCheckStrFromSession($sessionVariable, $expected_value) {
		$session_value = $_SESSION[$sessionVariable];
		if($expected_value === $session_value) {
			echo(' checked="checked" ');

			return true;
		} else {
			return false;
		}
	}


	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function stringFromFormToDB($str) {
		$str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

		return $str;
	}


	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function stringFromDB2HTML($str) {

		if(!$str || $str === null || $str === '' || is_array($str)) {
			return $str;
		}

		$str = trim($str);
		$str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

		return $str;
	}


	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function stringFromDB2Form($str) {
		$str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

		return $str;
	}


	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function stringFromDBtoXML($str) {

		$str = urlencode($str);

		return $str;
	}


	/**
	 * @param $ip
	 *
	 * @return string
	 */
	public static function makeGoodIP($ip) {
		$newIP = '';

		$ip_array = explode('.', $ip);

		if(is_array($ip_array)) {
			foreach($ip_array as $val) {

				$newIP .= str_pad($val, 3, '0', STR_PAD_LEFT) . '.';
			}
		}
		$newIP = substr($newIP, 0, strlen($newIP) - 1);

		return $newIP;
	}


	/**
	 * @param $ip
	 *
	 * @return string
	 */
	public static function make_good_ip_to_trace($ip) {

		$newIP = '';

		$ip_array = explode('.', $ip);

		if(is_array($ip_array)) {
			foreach($ip_array as $val) {

				if($val[0] === '0') {
					$val = $val[1] . $val[2];
				}

				if($val[0] === '0') {
					$val = $val[1] . $val[2];
				}

				$newIP .= $val . '.';
			}
		}

		$newIP = substr($newIP, 0, -1);

		return $newIP;
	}


	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function makeHTMLString($str) {
		$str = trim($str);
		$str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

		return nl2br($str);
	}


	/**
	 * @param $val
	 *
	 * @return mixed
	 */
	public static function brEncodedToHTML($val) {
		$pattern = '/&lt;br&gt;/';
		$val = preg_replace($pattern, '<br>', $val);

		//        $val = str_replace("&lt;br&gt;","<br>",$val);
		return $val;
	}


	/**
	 * @param     $str
	 * @param int $counts
	 *
	 * @return string
	 */
	public static function killLastSign($str, $counts = 1) {

		$str = substr($str, 0, strlen($str) - $counts);

		return $str;
	}


	/**
	 * @param $variName
	 * @param $vari_value
	 */
	public static function cuEchoVari($variName, $vari_value) {

		CuString::cuEcho($variName . ' => ' . $vari_value);
	}


	/**
	 * @param $str
	 */
	public static function cuEcho($str) {
		echo("<br />$str<br />");
	}


	/**
	 * @param $price
	 *
	 * @return string
	 */
	public static function make_price_from_db($price) {

		$price_element = explode('.', $price);

		$cent = $price_element[1];

		$cent = str_pad($cent, '0', STR_PAD_LEFT);

		$new_price = ',' . $price_element[0] . $cent;

		return $new_price;
	}


	/**
	 * @param      $vari
	 * @param bool $makeEcho
	 *
	 * @return mixed|string
	 */
	public static function debug_var_dump_formatted($vari, $makeEcho = true) {
		ob_start();

		/** @noinspection ForgottenDebugOutputInspection */
		print_r($vari);

		$output = ob_get_clean();

		$output = str_replace(' ', '&nbsp;', $output);
		$output = nl2br($output);

		if($makeEcho) {
			echo $output . '<br>';
		}

		return $output;
	}
}