<?php
/** @noinspection ParameterDefaultValueIsNotNullInspection */

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */
declare(strict_types=1);

namespace computerundsound\culibrary;

use Throwable;

/**
 * Class CuInfoMail
 *
 * @package culibrary
 */
class CuInfoMail
{

    protected int $chunkSplit;
    private string $subject;
    private string $mailText;
    private string $addressTo;
    private string $addressFrom;
    private string $nameTo;
    private string $nameFrom;
    private string $host;
    private int $additionalRow = 0;
    private array $userData;


    public function __construct(string $addressTo,
                                string $addressFrom,
                                string $nameTo,
                                string $nameFrom,
                                string $host = '',
                                int    $chunkSplit = 0)
    {

        $this->addressTo   = $addressTo;
        $this->addressFrom = $addressFrom;
        $this->nameFrom    = $nameFrom;
        $this->nameTo      = $nameTo;
        $this->host        = $host;
        $this->chunkSplit  = $chunkSplit;

        $this->userData = $this->getClientData();

        $this->buildStandardSubject();
        $this->buildMessage();

    }

    public static function getMailTemplate(): string
    {

        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $mailTemplate = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Email</title>

    <!--suppress SpellCheckingInspection -->
<style type="text/css">

        .bodyClass {
            padding: 0;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333333;
            background-color: #FAFAFA;
            text-align: left;
        }

        .h1 {
            font-size: 14px;
        }

        .h2 {
            font-size: 12px;
        }

        .myTable {
            margin-top: 10px;
        }

        .thead {
            font-size: 14px;
            font-weight: bold;
        }

        .td, .th {
            font-size: 11px;
            font-family: Arial, Helvetica, sans-serif;
            padding: 5px;
            text-align: right;
        }

        .th {
            text-align: left;
            width: 100px;
        }

        .zeileGrau {
            background-color: #F0F0F0;
        }

        .zeileHell {
            background-color: #FFFFFF;
        }

        a.mylink:link, a.mylink:visited, a.mylink:hover {
            color: maroon;
            text-decoration: none;
        }

    </style>


</head>

<body class="bodyClass">


<table class="myTable" cellpadding="0" cellspacing="0" width="500px" align="center">
    <tr>
        <td>
            <h1 class="h1">
                Request from page <a class="mylink" 
                                     href="https://###Server######Seite###">###Server######Seite###</a>
            </h1>
        </td>
    </tr>
    <tr>
        <td class="td" style="text-align: left;">
            <h2 class="h2">Userdata:</h2>   
            <table cellpadding="0" cellspacing="0" width="500px" align="left">
                <tr>
                    <th class="th thead"></th>
                    <td class="td thead"></td>
                </tr>
                <tr>
                    <th class="th zeileGrau">Server</th>
                    <td class="td zeileGrau">###Server###</td>
                </tr>
                <tr>
                    <th class="th zeileHell">Seite</th>
                    <td class="td zeileHell">###Seite###</td>
                </tr>
                <tr>
                    <th class="th zeileGrau">Time</th>
                    <td class="td zeileGrau">###Time###</td>
                </tr>
                <tr>
                    <th class="th zeileHell">IP</th>
                    <td class="td zeileHell">###IP###</td>
                </tr>
                <tr>
                    <th class="th zeileGrau">Host</th>
                    <td class="td zeileGrau">###Host###</td>
                </tr>
                <tr>
                    <th class="th zeileHell">Client</th>
                    <td class="td zeileHell">###Client###</td>
                </tr>
                <tr>
                    <th class="th zeileHell">Referer</th>
                    <td class="td zeileHell">###Referer###</td>
                </tr>
                <tr>
                    <th class="th zeileHell">Query</th>
                    <td class="td zeileHell">###Query###</td>
                </tr>
                <tr>
                    <th class="th zeileHell">Requests</th>
                    <td class="td zeileHell">###Requests###</td>
                </tr>

                <!--###ZUSATZ###-->

            </table>

        </td>
    </tr>

</table>



</body>
</html>';

        return $mailTemplate;
    }

    public function sendEmail(): void
    {


        try {
            CuMailer::sendHTMLMail($this->addressTo,
                                   $this->subject,
                                   $this->mailText,
                                   $this->addressFrom,
                                   $this->nameFrom,
                                   $this->nameTo,
                                   '',
                                   $this->host);
        } catch (Throwable $t) {
            echo $t->getMessage();
        }

    }

    public function addRow(string $name, string $value): void
    {

        $className = 'zeileGrau';
        if ($this->additionalRow % 2 === 0) {
            $className = 'zeileHell';
        }

        $this->additionalRow++;

        $zeile = '
        <tr>
            <th class="th ' . $className . '">' . $name . '</th>
            <td class="td ' . $className . '">' . $value . '</td>
        </tr>
        <!--###ZUSATZ###-->';

        $message = $this->mailText;

        $message = str_replace('<!--###ZUSATZ###-->', $zeile, $message);

        $this->mailText = $message;
    }

    public function changeSubject(string $subject): void
    {
        $this->subject = $subject;
    }


    protected function getClientData(): array
    {

        $userData = [];

        $userData['server']   = $this->getServerValue('SERVER_NAME');
        $userData['site']     = $this->getServerValue('PHP_SELF');
        $userData['ip']       = $this->getServerValue('REMOTE_ADDR');
        $userData['host']     = $userData['ip'] === '' ? '' : gethostbyaddr($userData['ip']);
        $userData['client']   = $this->getServerValue('HTTP_USER_AGENT');
        $userData['referer']  = $this->getServerValue('HTTP_REFERER');
        $userData['query']    = $this->getServerValue('QUERY_STRING');
        $userData['requests'] = $_REQUEST ?? [];
        $userData['requests'] = serialize($userData['requests']);

        return $userData;
    }


    protected function getServerValue(string $name): string
    {

        $name = trim($name);

        $value = '';

        if (isset($_SERVER[$name])) {
            $value = (string)$_SERVER[$name];
        }

        return $value;
    }


    protected function chunkValues(array $values, int $chunkLength): array
    {

        foreach ($values as &$value) {

            if (is_string($value)) {
                $value = chunk_split($value, $chunkLength);
            }

        }

        return $values;

    }

    private function buildStandardSubject(): void
    {

        $subject       = 'Request form page ' .
            htmlspecialchars($_SERVER['PHP_SELF'],
                             ENT_COMPAT,
                             'utf-8') .
            ' - ' .
            $this->userData['server'] .
            $this->userData['site'] .
            ' - ' .
            date('Y-m-d H:i:s');
        $this->subject = $subject;
    }


    private function buildMessage(): void
    {

        $template = self::getMailTemplate();
        $userData = $this->userData;

        $mailMessage = $template;

        $timeStr = date('d.m.Y') . ' --- ' . date('H:i.s') . ' Uhr';

        $requests = $userData['requests'];

        $replaceArray = [

            '###Server###'   => $userData['server'],
            '###Seite###'    => $userData['site'],
            '###Time###'     => $timeStr,
            '###IP###'       => $userData['ip'],
            '###Host###'     => $userData['host'],
            '###Client###'   => $userData['client'],
            '###Referer###'  => $userData['referer'],
            '###Query###'    => $userData['query'],
            '###Requests###' => $requests,
        ];

        if ($this->chunkSplit > 0) {
            $replaceArray = $this->chunkValues($replaceArray, $this->chunkSplit);
        }

        $mailMessage = str_replace(array_keys($replaceArray), array_values($replaceArray), $mailMessage);

        $this->mailText = $mailMessage;
    }
}