<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 00:25 MEZ
 */

namespace computerundsound\culibrary;

use RuntimeException;

/**
 * Class CuInfoMail
 *
 * @package culibrary
 */
class CuInfoMail
{

    /**
     * @var int
     */
    protected $chunkSplit;
    private   $subject;
    private   $mailText;
    private   $addressTo;
    private   $addressFrom;
    private   $nameFrom;

    private $additionalRow = 0;

    /** @var array */
    private $userData;


    /**
     * @param string $addressTo
     * @param string $addressFrom
     * @param string $nameFrom
     * @param int    $chunkSplit
     */
    public function __construct($addressTo, $addressFrom, $nameFrom, $chunkSplit = 0)
    {

        $this->addressTo   = $addressTo;
        $this->addressFrom = $addressFrom;
        $this->nameFrom    = $nameFrom;
        $this->chunkSplit  = $chunkSplit;

        $this->userData = $this->getClientData();

        $this->buildSubject();
        $this->buildMessage();
    }

    /**
     * @return string
     */
    public static function getMailTemplate()
    {

        $mailTemplate = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
        <td><h1 class="h1">Request from page <a class="mylink" href="http://###Server######Seite###">###Server######Seite###</a></h1></td>
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

    public function sendEmail()
    {

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        $header .= 'To: ' . $this->addressTo . "\r\n";
        $header .= 'From: ' . $this->nameFrom . '<' . $this->addressFrom . '>' . "\r\n";

        $this->subject;
        $this->mailText;

        $return = @mail($this->addressTo, $this->subject, $this->mailText, $header);

        if (!$return) {
            throw new RuntimeException('There was an Error while trying to send an email: ' . error_get_last()['message']);
        }


    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addRow($name, $value)
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

    /**
     * @return array;
     */
    protected function getClientData()
    {

        $userData = array();

        $userData['server']   = $this->getServerValue('SERVER_NAME');
        $userData['site']     = $this->getServerValue('PHP_SELF');
        $userData['ip']       = $this->getServerValue('REMOTE_ADDR');
        $userData['host']     = $userData['ip'] === '' ? '' : gethostbyaddr($userData['ip']);
        $userData['client']   = $this->getServerValue('HTTP_USER_AGENT');
        $userData['referer']  = $this->getServerValue('HTTP_REFERER');
        $userData['query']    = $this->getServerValue('QUERY_STRING');
        $userData['requests'] = isset($_REQUEST) ? $_REQUEST : array();
        $userData['requests'] = serialize($userData['requests']);

        return $userData;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getServerValue($name)
    {

        $name = trim((string)$name);

        $value = '';

        if (isset($_SERVER[$name])) {
            $value = (string)$_SERVER[$name];
        }

        return $value;
    }

    /**
     * @param array $values
     * @param int   $chunkLength
     *
     * @return array
     */
    protected function chunkValues(array $values, $chunkLength)
    {

        foreach ($values as &$value) {

            if (is_string($value)) {
                $value = chunk_split($value, $chunkLength);
            }

        }

        return $values;

    }

    private function buildSubject()
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

    /**
     *
     */
    private function buildMessage()
    {

        $template = self::getMailTemplate();
        $userData = $this->userData;

        $mailMessage = $template;

        $timeStr = date('d.m.Y') . ' --- ' . date('H:i.s') . ' Uhr';

        $requests = $userData['requests'];

        $replaceArray = array(

            '###Server###'   => $userData['server'],
            '###Seite###'    => $userData['site'],
            '###Time###'     => $timeStr,
            '###IP###'       => $userData['ip'],
            '###Host###'     => $userData['host'],
            '###Client###'   => $userData['client'],
            '###Referer###'  => $userData['referer'],
            '###Query###'    => $userData['query'],
            '###Requests###' => $requests,
        );

        if ($this->chunkSplit > 0) {
            $replaceArray = $this->chunkValues($replaceArray, $this->chunkSplit);
        }

        $mailMessage = str_replace(array_keys($replaceArray), array_values($replaceArray), $mailMessage);

        $this->mailText = $mailMessage;
    }
}