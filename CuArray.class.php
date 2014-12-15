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
class CuArray
{


	/**
	 * @param     $arrayToSort
	 * @param     $keyToSort
	 * @param int $parameter
	 *
	 * @return mixed
	 */
	public static function sortArray($arrayToSort, $keyToSort, $parameter = SORT_ASC)
	{

		foreach ($arrayToSort as $nr => $array)
		{
			foreach ($array as $key => $val)
			{
				$str = $array[$key];
				if (is_array($str))
				{
					${$key}[$nr] = $array[$key];
				}
				else
				{
					${$key}[$nr] = strtolower($array[$key]);
				}
			}
		}

		array_multisort($$keyToSort, $parameter, $arrayToSort);


		return $arrayToSort;
	}


	/**
	 * @param      $my_array
	 * @param      $value
	 * @param bool $key
	 */
	public static function set_pointer_from_value_or_key(&$my_array, $value, $key = false)
	{

		/* TODO-Jörg Wrase: Das ist noch nicht durchgetestet */

		reset($my_array);

		for ($key_nr = 0; $key_nr < count($my_array); $key_nr++)
		{
			$array_current_key   = key($my_array);
			$array_current_value = $my_array[$array_current_key];

			if ($key === false)
			{
				if ($array_current_value === $value)
				{
					break;
				}
				else
				{
					next($my_array);
				}
			}
			else
			{
				if ($array_current_key === $key)
				{
					break;
				}
				else
				{
					next($my_array);
				}
			}
		}
	}

	/**
	 * @param        $my_array
	 * @param string $new_value
	 */
	public static function set_all_values_if_null(&$my_array, $new_value = '-')
	{

		foreach ($my_array as $key => &$value)
		{

			if (is_array($value))
			{
				self::set_all_values_if_null($value, $new_value);
			}

			if (empty($value))
			{
				$value = $new_value;
			}
		}
	}
}