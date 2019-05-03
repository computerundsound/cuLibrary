<?php

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 00:20 MEZ
 */

namespace computerundsound\culibrary;

/**
 * Class CuNet
 *
 * @package culibrary
 */
class CuRequester
{

    /**
     * @return array | 'client', referer', 'server', 'site', 'query',
     */
    public static function getClientData()
    {

        $user_data_array = [];

        $ip                      = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $user_data_array['host'] = gethostbyaddr($ip) ?: '';

        $user_data_array['ip'] = $ip ?: '';

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
    public static function getGetOrPostSessionStandardValue($variableName, $standard_value)
    {

        $value = self::getGetPostSession($variableName);

        if (self::getGetPostSession($variableName) !== null) {
            $_SESSION[$variableName] = $standard_value;

            $value = $standard_value;
        }
        
        return $value;
    }


    /**
     * @param string $variableName
     *
     * @return string|array|null
     */
    public static function getGetPostSession($variableName)
    {

        $value = null;

        if (isset($_SESSION[$variableName])) {
            $value = $_SESSION[$variableName];
        }

        $postGetValue = self::getGetPost($variableName);

        if ($postGetValue !== null) {
            $value                   = $postGetValue;
            $_SESSION[$variableName] = $value;
        }

        return $value;
    }


    /**
     * @param string $variableName
     *
     * @return string|array|null
     */
    public static function getGetPost($variableName)
    {

        $value = null;

        if (isset($_GET[$variableName])) {
            $value = $_GET[$variableName];
        }

        if (isset($_POST[$variableName])) {
            $value = $_POST[$variableName];
        }

        $value = self::stripSlashesDeep($value);

        return $value;
    }


    /**
     *
     * @param $value
     *
     * @return array|string
     * will only do something when get_magic_quotes_gpc === true
     */
    public static function stripSlashesDeep($value)
    {

        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            $value = is_array($value) ? array_map([__CLASS__, 'stripSlashesDeep'], $value) : stripcslashes($value);
        }

        return $value;
    }
}
