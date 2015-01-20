<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 18.01.2015
 * Time: 03:23
 * 
 * Created by IntelliJ IDEA
 *
 */

/**
 * Class CuFactory
 */
class CuFactory
{


	/**
	 * @var array // Syntax: array('ClassName' => array([paramter_01_value], [paramter_02_value], ...);
	 */
	protected static $classConfigurationArray;

	private function __construct()
	{
	}


	/**
	 * @param array $classConfigurationArray
	 */
	public static function setClassConfiguration(array $classConfigurationArray)
	{
		self::$classConfigurationArray = $classConfigurationArray;
	}

	/**
	 * @param  string $className
	 * @return null|object
	 */
	public static function create($className)
	{
		$parameterArray = array();

		$classInstance = null;
		$class         = new ReflectionClass($className);
		if ($class)
		{

			$constructor = $class->getConstructor();
			if ($constructor)
			{
				$parameterAll = $constructor->getParameters();

				foreach ($parameterAll as $parameter)
				{

					if ($parameter)
					{
						$typeHint = self::isTypeHintParameter($parameter);
						$position = $parameter->getPosition();

						if (isset(self::$classConfigurationArray[$className][$position]))
						{
							$parameterArray[] = self::$classConfigurationArray[$className][$position];
						}
						else
						{
							if ($typeHint !== false)
							{
								$parameterArray[] = self::create($typeHint);
							}
						}
					}
				}
			}

			$classInstance = $class->newInstanceArgs($parameterArray);

		}

		return $classInstance;

	}

	/**
	 * @param ReflectionParameter $parameter
	 *
	 * @return bool
	 */
	protected static function isTypeHintParameter(ReflectionParameter $parameter)
	{
		$ret = false;

		$typeHintClass = $parameter->getClass();

		if (is_object($typeHintClass))
		{
			$typeHint = $typeHintClass->name;
			if ($typeHint)
			{
				$ret = $typeHint;
			}
		}

		return $ret;
	}

	/**
	 * @param $className
	 *
	 * @return bool
	 */
	protected static function classNameHasTypeHints($className)
	{
		$ret = false;

		$class = new ReflectionClass($className);
		if ($class)
		{
			$constructor = $class->getConstructor();
			if ($constructor)
			{
				$parameterAll = $constructor->getParameters();

				foreach ($parameterAll as $parameter)
				{
					if ($parameter)
					{
						$typeHint = self::isTypeHintParameter($parameter);

						if ($typeHint !== false)
						{
							$ret = true;
						}
					}
				}
			}
		}

		return $ret;
	}
}
