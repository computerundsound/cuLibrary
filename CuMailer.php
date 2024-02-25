<?php

namespace computerundsound\culibrary;

class CuMailer
{

    public static function sendHTMLMail(string $toAddress,
                                        string $subject = '',
                                        string $content = '',
                                        string $fromName = '',
                                        string $toName = '',
                                        array  $addHeader = [])
    {

        $header = 'MIME-Version: 1.0' . PHP_EOL;
        $header .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;

        if ($toAddress) {
            $header .= 'To: ' . $toAddress . "\r\n";
        }
        if ($fromName && $fromAddress) {
            $header .= 'From: ' . $fromName . '<' . $fromAddress . '>' . PHP_EOL;
        }

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $return = @mail($toAddress, $subject, $content, $header);

        if (!$return) {
            throw new RuntimeException('There was an Error while trying to send an email: ' .
                                       error_get_last()['message']);
        }

    }
}