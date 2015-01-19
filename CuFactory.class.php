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
	 * @param  string $className
	 * @param array   $parameterListArray
	 *
	 * @return null|object
	 */
	public static function create($className, $parameterListArray = array())
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

						if ($typeHint !== false)
						{
							if (isset($parameterListArray[$position]))
							{
								$parameterArray[] = $parameterListArray[$position];
							}
							else
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
