<?php
/**
 * Copyright by Jörg Wrase - Computer-Und-Sound.de
 * Date: 08.08.12
 * Time: 23:38
 *
 * Created by JetBrains PhpStorm
 *
 * Filename: CuInfoMail.class.php
 */

namespace computerundsound\culibrary;

/**
 * Class CuInfoMail
 *
 * @package curlibrary
 */
class CuInfoMail {

	private $_subject;
	private $_mailtext;
	private $_adresseTo;
	private $_addressFrom;
	private $_nameFrom;

	private $_aktuelleZusatzZeile = 0;

	private $_userDaten = array();


	/**
	 * @param $addressTo
	 * @param $addressFrom
	 * @param $nameFrom
	 */
	public function __construct($addressTo, $addressFrom, $nameFrom) {

		$this->_adresseTo   = $addressTo;
		$this->_addressFrom = $addressFrom;
		$this->_nameFrom    = $nameFrom;

		$this->_userDaten = $this->getClientData();

		$this->buildSubject();
		$this->buildMessage();
	}


	/**
	 * @return string
	 */
	public static function getMailTemplate() {
		/** @noinspection SpellCheckingInspection */
		$mailTemplate = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Titel des Dokuments</title>

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
        <td><h1 class="h1">Auruf der Seite <a class="mylink" href="http://###Server######Seite###">###Server######Seite###</a></h1></td>
            </tr>
    <tr>
        <td class="td" style="text-align: left;">
            <h2 class="h2">Userdaten:</h2>
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


	public function sendEmail() {

		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		$header .= 'To: ' . $this->_adresseTo . "\r\n";
		$header .= 'From: ' . $this->_nameFrom . '<' . $this->_addressFrom . '>' . "\r\n";

		$this->_subject;
		$this->_mailtext;

		mail($this->_adresseTo, $this->_subject, $this->_mailtext, $header);
	}


	/**
	 * @param $name
	 * @param $wert
	 */
	public function addZeile($name, $wert) {

		$className = 'zeileGrau';
		if($this->_aktuelleZusatzZeile % 2 === 0) {
			$className = 'zeileHell';
		}

		$this->_aktuelleZusatzZeile++;

		$zeile = '
        <tr>
            <th class="th ' . $className . '">' . $name . '</th>
            <td class="td ' . $className . '">' . $wert . '</td>
        </tr>
        <!--###ZUSATZ###-->';

		$message = $this->_mailtext;

		$message = str_replace('<!--###ZUSATZ###-->', $zeile, $message);

		$this->_mailtext = $message;
	}


	/**
	 * @return array;
	 */
	protected function getClientData() {

		$userDaten = array();

		$userDaten['server']   = $this->getServerValue('SERVER_NAME');
		$userDaten['site']     = $this->getServerValue('PHP_SELF');
		$userDaten['ip']       = $this->getServerValue('REMOTE_ADDR');
		$userDaten['host']     = $userDaten['ip'] === '' ? '' : gethostbyaddr($userDaten['ip']);
		$userDaten['client']   = $this->getServerValue('HTTP_USER_AGENT');
		$userDaten['referer']  = $this->getServerValue('HTTP_REFERER');
		$userDaten['query']    = $this->getServerValue('QUERY_STRING');
		$userDaten['requests'] = isset($_REQUEST) ? $_REQUEST : array();
		$userDaten['requests'] = serialize($userDaten['requests']);

		return $userDaten;
	}


	/**
	 * @param $name
	 *
	 * @return int
	 */
	protected function getServerValue($name) {

		$name = trim((string)$name);

		$value = 0;

		if(isset($_SERVER[$name])) {
			$value = $_SERVER[$name];
		}

		return $value;
	}


	private function buildSubject() {
		$subject        = 'Aufruf der Seite ' . htmlspecialchars($_SERVER['PHP_SELF'],
		                                                         ENT_COMPAT,
		                                                         'utf-8') . ' - ' . $this->_userDaten['server']
		                  . $this->_userDaten['site'] . ' - ' . date('Y-m-d H:i:s');
		$this->_subject = $subject;
	}


	private function buildMessage() {
		$template  = self::getMailTemplate();
		$userDaten = $this->_userDaten;

		$mailMessage = $template;

		$timeStr = date('d.m.Y') . ' --- ' . date('H:i.s') . ' Uhr';

		$requests = $userDaten['requests'];

		$replaceArray = array(

			'###Server###'    => $userDaten['server'],
			'###Seite###'     => $userDaten['site'],
			'###Time###'      => $timeStr,
			'###IP###'        => $userDaten['ip'],
			'###Host###'      => $userDaten['host'],
			'###Client###'    => $userDaten['client'],
			'###Referer###'   => $userDaten['referer'],
			'###Query###'     => $userDaten['query'],
			'###Requests###' => $requests,
        );

		$mailMessage = str_replace(array_keys($replaceArray), array_values($replaceArray), $mailMessage);

		$this->_mailtext = $mailMessage;
	}
}