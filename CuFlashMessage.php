<?php /** @noinspection PhpUnused */
declare(strict_types=1);


namespace computerundsound\culibrary;


/**
 * Class CuFlashMessage
 *
 * @package computerundsound\culibrary
 */
class CuFlashMessage
{

    protected static string $flashMessage = '';

    protected static string $sessionVariableName = 'cu_flash_message';


    public static function get(): string
    {

        self::startSession();
        if (self::$flashMessage === '') {
            self::loadFromSession();
            self::clearSession();
        }

        return self::$flashMessage;
    }


    public static function save(string $message): void
    {

        self::startSession();
        $_SESSION[self::$sessionVariableName] = $message;
    }

    public static function setNewSessionVariableName(string $sessionVariableName): void
    {

        self::$sessionVariableName = $sessionVariableName;

    }

    protected static function startSession(): void
    {

        if (!session_id()) {
            session_start();
        }
    }

    protected static function loadFromSession(): void
    {

        self::$flashMessage = isset($_SESSION[self::$sessionVariableName]) ?
            (string)$_SESSION[self::$sessionVariableName] : '';

    }

    protected static function clearSession(): void
    {

        $_SESSION[self::$sessionVariableName] = '';
    }
}