<?php
/** @noinspection PhpUnused */
declare(strict_types=1);

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

namespace computerundsound\culibrary;

class CuRequester
{

    /**
     * @return array | 'client', referer', 'server', 'site', 'query',
     */
    public static function getClientData(): array
    {

        $user_data_array = [];

        $ip                      = $_SERVER['REMOTE_ADDR'] ?? '';
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
            $user_data_array[$val] = $_SERVER[$key] ?? '';
        }

        return $user_data_array;
    }


    /**
     * @param string $variableName
     * @param mixed  $standard_value
     *
     * @return bool|string
     */
    public static function getGetOrPostSessionStandardValue(string $variableName, $standard_value)
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
    public static function getGetPostSession(string $variableName)
    {

        $value = $_SESSION[$variableName] ?? null;

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
    public static function getGetPost(string $variableName)
    {

        $value = $_POST[$variableName] ?? $_GET[$variableName] ?? null;

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

        /** @noinspection PhpDeprecationInspection */
        if (function_exists('get_magic_quotes_gpc') && PHP_VERSION < 7 && get_magic_quotes_gpc()) {
            $value = is_array($value) ? array_map([__CLASS__, 'stripSlashesDeep'], $value) : stripcslashes($value);
        }

        return $value;
    }
}
