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
	 * @var array | Syntax: array('ClassName' => array([paramter_01_value], [paramter_02_value], ...);
	 */
	protected $classConfigurationArray;

	/**
	 * @param array $classConfigurationArray
	 */
	public function __construct(array $classConfigurationArray)
	{
		$this->classConfigurationArray = $classConfigurationArray;
	}

	/**
	 * @param  string $className
	 * @param array   $parameterListArray
	 *
	 * @return null|object
	 */
	public function create($className)
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
						$typeHint = $this->isTypeHintParameter($parameter);
						$position = $parameter->getPosition();


						if(isset($this->classConfigurationArray[$className][$position])) {
							$parameterArray = $this->classConfigurationArray[$position];
						} else
						{
							if ($typeHint !== false)
							{

								if (isset($this->classConfigurationArray[$typeHint]))

								{
									$parameterArray[] = $this->create($typeHint);
								}
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
	protected function classNameHasTypeHints($className)
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
						$typeHint = $this->isTypeHintParameter($parameter);

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
