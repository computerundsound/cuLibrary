<?php

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.20 at 02:59 MEZ
 */

namespace computerundsound\culibrary;

/**
 * Class CuNet
 *
 * @package curlibrary
 */
class CuNet
{

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

        foreach ($userDataKeyValueArray as $key => $val) {
            $user_data_array[$val] = '';
            if (isset($_SERVER[$key])) {
                $user_data_array[$val] = $_SERVER[$key];
            }
        }

        return $user_data_array;
    }


    /**
     * @param $variableName
     * @param $standard_value
     *
     * @return bool|string
     */
    public static function get_post_session_standard_value($variableName, $standard_value) {

        $fromRequestOrSession = self::get_post_session($variableName);

        if ($fromRequestOrSession) {
            $value = $fromRequestOrSession;
        } else {
            $_SESSION[$variableName] = $standard_value;
            $value                   = $standard_value;
        }

        return $value;
    }


    /**
     * @param $variableName
     *
     * @return mixed
     */
    public static function get_post_session($variableName) {

        $value = null;

        if (isset($_SESSION[$variableName])) {
            $value = $_SESSION[$variableName];
        }

        $postGetValue = self::get_post($variableName);

        if ($postGetValue !== null) {
            $value                   = $postGetValue;
            $_SESSION[$variableName] = $value;
        }

        return $value;
    }


    /**
     * @param $variableName
     *
     * @return mixed
     */
    public static function get_post($variableName) {

        $value = null;

        if (isset($_GET[$variableName])) {
            $value = $_GET[$variableName];
        }

        if (isset($_POST[$variableName])) {
            $value = $_POST[$variableName];
        }

        $value = self::strip_slashes_deep($value);

        return $value;
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
            $value = is_array($value) ? array_map([
                                                      __CLASS__,
                                                      'strip_slashes_deep',
                                                  ],
                                                  $value) : stripcslashes($value);
        }

        return $value;
    }
}
