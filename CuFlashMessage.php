<?php


namespace computerundsound\culibrary;


class CuFlashMessage
{

    /** @var string */
    protected static $flashMessage = '';
    /** @var string */
    protected static $sessionVariableName = 'cu_flash_message';


    /**
     * @return string
     */
    public static function get()
    {

        self::startSession();
        if (self::$flashMessage === '') {
            self::loadFromSession();
            self::clearSession();
        }

        return self::$flashMessage;
    }

    /**
     * @param string $message
     */
    public static function save($message)
    {

        self::startSession();
        $_SESSION[self::$sessionVariableName] = (string)$message;
    }

    public static function setNewSessionVariableName($sessionVariableName)
    {

        self::$sessionVariableName = (string)$sessionVariableName;

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