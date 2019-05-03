<?php


namespace computerundsound\culibrary;


class CuDebug
{

    public static function show($value, $showAsHtml = true, $exit = false)
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