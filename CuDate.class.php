<?php

/**
 * Copyright by Jörg Wrase - Computer-Und-Sound.de
 * Date: 24.06.12
 * Time: 00:37
 *
 * Created by JetBrains PhpStorm
 *
 * Filename: CuDate.class.php
 */
class CuDate
{


	/**
	 * @param $ts
	 *
	 * @return bool|string
	 */
	public static function makeDatumFromTimestamp($ts)
	{
		$tstr = date("d.m.Y", $ts);

		return $tstr;
	}

	/**
	 * @param $mySQLDatum
	 *
	 * @return int
	 */
	public static function makeTimestampFromMySQLDatum($mySQLDatum)
	{
		$data_array = explode("-", $mySQLDatum);

		$timestamp = mktime(1, 0, 0, $data_array[1], $data_array[2], $data_array[0]);

		return $timestamp;

	}

	/**
	 * @param $myGermanDatum
	 *
	 * @return int
	 */
	public static function makeTimestampFromGermanDatum($myGermanDatum)
	{
		$daten = explode(".", $myGermanDatum);

		$monat = floatval($daten[1]);
		$day   = floatval($daten[0]);
		$jahr  = floatval($daten[2]);

		$timestamp = mktime(1, 0, 0, $monat, $day, $jahr);

		return $timestamp;

	}


	/**
	 * @param $timestamp
	 *
	 * @return string
	 */
	public static function makeMySQLDatumFromTimestamp($timestamp)
	{
		$mySQLDatum = date("Y", $timestamp) . "-" . date("m", $timestamp) . "-" . date("d", $timestamp);

		return $mySQLDatum;
	}

	/**
	 * @param $mySQLDatum
	 *
	 * @return string
	 */
	public static function makeGermanDatumFromMysql($mySQLDatum)
	{
		$daten = explode("-", $mySQLDatum);

		foreach ($daten as $key => $val)
		{

			$daten[$key] = str_pad($val, 2, "0", STR_PAD_LEFT);

		}

		$germanDatum = $daten[2] . "." . $daten[1] . "." . $daten[0];

		return $germanDatum;

	}

	/**
	 * @param $timestamp
	 *
	 * @return string
	 */
	public static function makeGermanZeitpunktFromTimestamp($timestamp)
	{
		$date  = self::makeDatumFromTimestamp($timestamp);
		$clock = self::makeUhrzeitFromTimestamp($timestamp);

		return $date . " - " . $clock;
	}

	/**
	 * @param $myGermanDatum
	 *
	 * @return string
	 */
	public static function makeMYSQLfromGermanDatum($myGermanDatum)
	{

		$t = CuDate::makeTimestampFromGermanDatum($myGermanDatum);

		$mySQL = CuDate::makeMySQLDatumFromTimestamp($t);

		return $mySQL;

	}

	/**
	 * @param $mysqlDatum
	 *
	 * @return array
	 */
	public static function mysqlDatumZerlege($mysqlDatum)
	{
		$datumsElemente = explode("-", $mysqlDatum);

		return $datumsElemente;

	}

	/**
	 * @param $year
	 * @param $month
	 * @param $day
	 *
	 * @return bool|string
	 */
	public static function mysqlDatumSetzeZusammen($year, $month, $day)
	{
		$time    = mktime(0, 0, 0, $month, $day, $year);
		$newDate = date("Y-m-d", $time);

		return $newDate;
	}

	/**
	 * @param $ts
	 *
	 * @return bool|string
	 */
	public static function makeUhrzeitFromTimestamp($ts)
	{
		$tstr = date("H:i", $ts);

		return $tstr;
	}

	/**
	 * @return array
	 */
	public static function allMonateAufDeutsch()
	{

		$monate = array(
			"Jan" => "Januar",
			"Feb" => "Februar",
			"Mär" => "März",
			"Apr" => "April",
			"Mai" => "Mai",
			"Jun" => "Juni",
			"Jul" => "Juli",
			"Aug" => "August",
			"Spt" => "September",
			"Okt" => "Oktober",
			"Nov" => "November",
			"Dez" => "Dezember"
		);

		return $monate;
	}

	/**
	 * @return array
	 */
	public static function allWochentageAufDeutsch()
	{

		$wochentage = array(
			"Mo" => "Montag",
			"Di" => "Dienstag",
			"Mi" => "Mittwoch",
			"Do" => "Donnerstag",
			"Fr" => "Freitag",
			"Sa" => "Samstag",
			"So" => "Sonntag"
		);

		return $wochentage;
	}

}
