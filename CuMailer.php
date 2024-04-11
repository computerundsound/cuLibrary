<?php

namespace computerundsound\culibrary;

use RuntimeException;

class CuMailer
{

    public static function sendHTMLMail(string $toAddress,
                                        string $subject = '',
                                        string $content = '',
                                        string $fromAddress = '',
                                        string $fromName = '',
                                        string $toName = '',
                                        array  $addHeader = []): void
    {

        $header = self::buildHeader($toAddress, $fromAddress, $fromName, $toName, $addHeader);

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $return = @mail($toAddress, $subject, $content, $header);

        if (!$return) {
            throw new RuntimeException('There was an Error while trying to send an email: ' .
                                       error_get_last()['message']);
        }

    }

    public static function buildHeader(string $toAddress,
                                       string $fromAddress,
                                       string $fromName,
                                       string $toName,
                                       array  $addHeader): string
    {
        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        if ($toAddress && !$toName) {
            $header .= 'To: ' . $toAddress . "\r\n";
        }

        if ($toAddress && $toName) {
            $header .= 'From: ' . $toName . '<' . $toAddress . '>' . "\r\n";
        }

        if ($fromAddress && !$fromName) {
            $header .= 'To: ' . $fromAddress . "\r\n";
        }

        if ($fromAddress && $fromName) {
            $header .= 'From: ' . $fromName . '<' . $fromAddress . '>' . "\r\n";
        }

        foreach ($addHeader as $key => $value) {
            $header .= "$key: $value" . "\r\n";
        }

        return $header;

    }
}