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

/**
 * Class DateTimeCu
 */
class DateTimeCu extends DateTime
{

	/** @var DateTime | null */
	protected $dateTime = null;

	/**
	 * @param string $dateString
	 */
	public function __construct($dateString = null)
	{

		if (empty($dateString) === false)
		{
			parent::__construct();
		}
		else
		{
			if (strtotime($dateString) !== false)
			{
				parent::__construct($dateString);
			}
		}
	}

	protected function setNowIfNotSet(){
		if($this->dateTime === null) {
			$this->dateTime = new DateTime();
		}
	}

}