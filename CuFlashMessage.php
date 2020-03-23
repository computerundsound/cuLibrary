<?php /** @noinspection PhpUnused */


namespace computerundsound\culibrary;


/**
 * Class CuFlashMessage
 *
 * @package computerundsound\culibrary
 */
class CuFlashMessage
{

    protected static $flashMessage = '';

    protected static $sessionVariableName = 'cu_flash_message';


    public static function get()
    {

        self::startSession();
        if (self::$flashMessage === '') {
            self::loadFromSession();
            self::clearSession();
        }

        return self::$flashMessage;
    }


    public static function save($message)
    {

        self::startSession();
        $_SESSION[self::$sessionVariableName] = $message;
    }

    public static function setNewSessionVariableName($sessionVariableName)
    {

        self::$sessionVariableName = $sessionVariableName;

    }

    protected static function startSession()
    {

        if (!session_id()) {
            session_start();
        }
    }

    protected static function loadFromSession()
    {

        self::$flashMessage = isset($_SESSION[self::$sessionVariableName]) ?
            (string)$_SESSION[self::$sessionVariableName] : '';

    }

    protected static function clearSession()
    {

        $_SESSION[self::$sessionVariableName] = '';
    }
}