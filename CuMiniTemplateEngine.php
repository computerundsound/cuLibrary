<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 11.05.2015
 * Time: 21:51
 * 
 * Created by IntelliJ IDEA
 *
 */
namespace computerundsound\culibrary;

/**
 * Class CuMiniTemplateEngine
 *
 * @package curlibrary
 */
class CuMiniTemplateEngine {

	private $variablesForTemplate = [];

	private $templateFolder = '';


	/**
	 * @param $templateFolder
	 */
	public function setTemplateFolder($templateFolder) {

		if(is_dir($templateFolder) === false) {
			throw new \DomainException("Templatefolder $templateFolder not found");
		}

		$this->templateFolder = $templateFolder;
	}


	/**
	 * @param $name
	 * @param $value
	 */
	public function assign($name, $value) {
		$this->variablesForTemplate[$name] = $value;
	}


	/**
	 * @param $template
	 */
	public function display($template) {

		/** @noinspection PhpIncludeInspection */
		include($this->templateFolder . $template . '.php');
	}


	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function getValue($name) {

		$returnValue = '';

		if(array_key_exists($name, $this->variablesForTemplate)) {
			$returnValue = $this->variablesForTemplate[$name];
		}

		return $returnValue;
	}


	/**
	 * @param      $name
	 * @param bool $html
	 */
	public function showValue($name, $html = false) {
		$value = $this->getValue($name);

		if($html) {
			$value = htmlspecialchars($html, ENT_COMPAT, 'utf-8');
		}

		echo $value;
	}
}