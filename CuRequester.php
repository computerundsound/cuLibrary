<?php
/** @noinspection PhpUnused */


/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

namespace computerundsound\culibrary;

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
            $user_data_array[$val] = isset($_SERVER[$key]) ? $_SERVER[$key] : '';
        }

        return $user_data_array;
    }


    /**
     * @param string $variableName
     * @param mixed  $standard_value
     *
     * @return |string
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

        $value = isset($_SESSION[$variableName]) ? $_SESSION[$variableName] : null;

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

        $value    = isset($_POST[$variableName]) ? $_POST[$variableName] : null;
        $valueGet = isset($_GET[$variableName]) ? $_GET[$variableName] : null;

        $value = $value ?: $valueGet;

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

        if (function_exists('get_magic_quotes_gpc') && PHP_VERSION < 7) {
            require_once __DIR__ . '/include/stripSlashes.php';
        }

        return $value;
    }
}
