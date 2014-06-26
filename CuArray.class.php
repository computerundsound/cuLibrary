<?php

/**
 * Copyright by Jörg Wrase - Computer-Und-Sound.de
 * Date: 29.07.12
 * Time: 16:06
 *
 * Created by JetBrains PhpStorm
 *
 * Filename: CuArray.class.php
 */
class CuArray {


	/**
	 * @param     $arrayToSort
	 * @param     $keyToSort
	 * @param int $parameter
	 *
	 * @return mixed
	 */
	public static function sortArray($arrayToSort, $keyToSort, $parameter = SORT_ASC) {

		foreach ($arrayToSort as $nr => $array) {
			foreach ($array as $key => $val) {
				$str = $array[$key];
				if (is_array($str)) {
					${$key}[$nr] = $array[$key];
				} else {
					${$key}[$nr] = strtolower($array[$key]);
				}
			}
		}

		array_multisort($$keyToSort, $parameter, $arrayToSort);


		return $arrayToSort;
	}
}
