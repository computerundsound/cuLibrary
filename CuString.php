<?php /** @noinspection PhpUnused */


/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

namespace computerundsound\culibrary;

/**
 * Class CuString
 *
 * @package culibrary
 */
class CuString
{


    public function __construct()
    {
    }


    /**
     * @param string $sessionVariable
     * @param        $expected_value
     *
     * @return
     */
    public static function getCheckStrFromSession($sessionVariable, $expected_value)
    {

        $success = false;

        $session_value = $_SESSION[$sessionVariable];
        if ($expected_value === $session_value) {
            echo(' checked="checked" ');

            $success = true;

        }

        return $success;
    }


    /**
     * @param string $str
     *
     * @return string
     */
    public static function stringFromFormToDB($str)
    {

        $str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

        return $str;
    }


    /**
     * @param string $str
     *
     * @return string
     */
    public static function stringFromDB2HTML($str)
    {

        if (!$str || $str === null || $str === '') {
            return $str;
        }

        $str = trim($str);
        $str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

        return $str;
    }


    /**
     * @param string $str
     *
     * @return string
     */
    public static function stringFromDB2Form($str)
    {

        $str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

        return $str;
    }


    /**
     * @param string $str
     *
     * @return string
     */
    public static function stringFromDBtoXML($str)
    {

        $str = urlencode($str);

        return $str;
    }


    /**
     * @param string $ip
     *
     * @return string
     */
    public static function makeGoodIP($ip)
    {

        $newIP = '';

        $ip_array = explode('.', $ip);

        if (is_array($ip_array)) {
            foreach ($ip_array as $val) {
                $newIP .= str_pad($val, 3, '0', STR_PAD_LEFT) . '.';
            }
        }
        $newIP = substr($newIP, 0, -1);

        return $newIP;
    }


    /**
     * @param string $ip
     *
     * @return string
     */
    public static function makeGoodIpToTrace($ip)
    {

        $newIP = '';

        $ip_array = explode('.', $ip);

        if (is_array($ip_array)) {
            foreach ($ip_array as $val) {

                if (strpos($val, '0') === 0) {
                    $val = $val[1] . $val[2];
                }

                $newIP .= $val . '.';
            }
        }

        $newIP = substr($newIP, 0, -1);

        return $newIP;
    }


    /**
     * @param string $str
     *
     * @return string
     */
    public static function makeHTMLString($str)
    {

        $str = trim($str);
        $str = htmlspecialchars($str, ENT_COMPAT, 'utf-8');

        return nl2br($str);
    }


    /**
     * @param string $val
     *
     * @return mixed
     */
    public static function brEncodedToHTML($val)
    {

        $pattern = '/&lt;br&gt;/';
        $val     = preg_replace($pattern, '<br>', $val);

        //        $val = str_replace("&lt;br&gt;","<br>",$val);
        return $val;
    }


    /**
     * @param string $str
     * @param int    $counts
     *
     * @return string
     */
    public static function killLastSign($str, $counts = 1)
    {

        $str = substr($str, 0, -$counts);

        return $str;
    }


    /**
     * @param string $variableName
     * @param        $variableValue
     */
    public static function cuEchoVariable($variableName, $variableValue)
    {

        self::cuEcho($variableName . ' => ' . $variableValue);
    }


    /**
     * @param string $str
     */
    public static function cuEcho($str)
    {

        echo("<br />$str<br />");
    }


    /**
     * @param $price
     *
     * @return string
     */
    public static function makePriceFromDB($price)
    {

        $price_element = explode('.', $price);

        $cent = $price_element[1];

        $cent = str_pad($cent, '0', STR_PAD_LEFT);

        return ',' . $price_element[0] . $cent;
    }

}