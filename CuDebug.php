<?php
declare(strict_types=1);


namespace computerundsound\culibrary;


use Throwable;

/**
 * Class CuDebug
 *
 * @package computerundsound\culibrary
 */
class CuDebug
{

    /**
     * @param mixed $value
     * @param bool $showAsHtml
     * @param bool $exit
     */
    public static function show(mixed $value, bool $showAsHtml = true, bool $exit = false): void
    {

        $valueToOutput = is_array($value) ? $value : [$value];

        $output = print_r($valueToOutput, true);

        if ($showAsHtml) {
            $output = '<pre>' . $output . '</pre>';
        }

        echo $output;

        if ($exit) {
            exit;
        }

    }

    public static function showPHPErrorMessage(Throwable $t, bool $showCode = false)
    {

        echo '<pre>';
        echo $t->getMessage();
        echo "\n\n";
        echo $t->getFile() . ':' . $t->getLine();
        echo "\n\n";
        echo $t->getTraceAsString();

        if ($showCode) {
            echo "\n\n\n";
            echo $t->getPrevious();
            echo "\n\n";
            echo $t->getCode();
        }

    }

}