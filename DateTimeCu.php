<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 25.12.2014
 * Time: 16:26
 *
 * Created by IntelliJ IDEA
 *
 * Filename: DateTimeCu.php
 */

namespace computerundsound\culibrary;

/**
 * Class DateTimeCu
 */
class DateTimeCu extends \DateTime {

	/** @var bool */
	protected $dateTimeIsNotNull = false;

	/**
	 * @internal param string $dateString
	 * @internal param DateTimeZone $dateTimeZone
	 */
	/** @noinspection MagicMethodsValidityInspection */
	public function __construct() {
		$this->initIntern('');
	}


	/**
	 *
	 */
	public function reset() {
		parent::__construct();
		$this->dateTimeIsNotNull = false;
	}


	public function setNowIfNotSet() {
		parent::__construct();
		$this->dateTimeIsNotNull = true;
	}


	/**
	 * @param null          $dateString
	 * @param \DateTimeZone $dateTimeZone
	 */
	public function init($dateString = null, \DateTimeZone $dateTimeZone = null) {
		$this->initIntern($dateString, $dateTimeZone);
	}


	/**
	 * Returns date formatted according to given format.
	 *
	 * @param string $format
	 *
	 * @return string
	 * @link http://php.net/manual/en/datetime.format.php
	 */
	public function format($format) {

		$retStr = '';

		$format = trim($format);

		if($this->dateTimeIsNotNull) {
			$retStr = parent::format($format);
		}

		return $retStr;
	}


	/**
	 * @param string        $dateString
	 * @param \DateTimeZone $dateTimeZone
	 */
	protected function initIntern($dateString, \DateTimeZone $dateTimeZone = null) {
		$this->reset();
		if(($dateString = $this->testValideDateString($dateString)) !== false) {
			parent::__construct($dateString, $dateTimeZone);
			$this->dateTimeIsNotNull = true;
		}
	}


	/**
	 * @param $dateString
	 *
	 * @return string
	 */
	private function testValideDateString($dateString) {
		$ret = '';

		$dateString = trim($dateString);

		if(strtotime($dateString) > 0) {
			$ret = $dateString;
		}

		return $ret;
	}
}