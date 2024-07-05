<?php

namespace computerundsound\culibrary;

use PHPMailer\PHPMailer\PHPMailer;

class CuMailer
{

    public static function sendHTMLMail(string $toAddress,
                                        string $subject = '',
                                        string $content = '',
                                        string $fromAddress = '',
                                        string $fromName = '',
                                        string $toName = '',
                                        string $replyToAddress = '',
                                        string $host = '',
                                        array  $addHeader = []): void
    {

        $host = $host ?? $_SERVER['SERVER_NAME'];

        $phpMailer           = new PHPMailer(false);
        $phpMailer->CharSet  = 'UTF-8';
        $phpMailer->Encoding = 'base64';
        $phpMailer->isHTML(true);

        $phpMailer->setFrom($fromAddress, $fromName);
        $phpMailer->addAddress($toAddress, $toName);

        $phpMailer->Subject = $subject;
        $phpMailer->Body    = $content;
        $phpMailer->send();


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