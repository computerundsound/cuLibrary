<?php
declare(strict_types=1);


namespace computerundsound\culibrary;


/**
 * Class CuDebug
 *
 * @package computerundsound\culibrary
 */
class CuDebug
{

    /**
     * @param mixed $value
     * @param bool  $showAsHtml
     * @param bool  $exit
     */
    public static function show($value, bool $showAsHtml = true, bool $exit = false): void
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

}