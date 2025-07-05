<?php

namespace computerundsound\culibrary;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CuMailer
{

    /**
     * @throws Exception
     */
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
        $toAddresses = self::createAddressArray($toAddress);
        foreach ($toAddresses as $toAddress) {
            $phpMailer->addAddress($toAddress, $toName);
        }

        $phpMailer->Subject = $subject;
        $phpMailer->Body    = $content;

        $phpMailer->send();


    }

    private static function createAddressArray(string $toAddress): array
    {

        $addresses = explode(',', $toAddress);

        return $addresses;
    }
}