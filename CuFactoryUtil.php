<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.19 at 01:47 MEZ
 */

namespace computerundsound\culibrary;

/**
 * Class CuFactoryUtil
 */
final class CuFactoryUtil
{


    /**
     * @var array // Syntax: array('ClassName' => array([parameter_01_value], [parameter_02_value], ...);
     */
    protected static $classConfigurationArray;


    /**
     *
     */
    private function __construct() {

    }


    /**
     * @param array $classConfigurationArray
     */
    public static function setClassConfiguration(array $classConfigurationArray) {

        self::$classConfigurationArray = $classConfigurationArray;
    }


    /**
     * @param  string $className
     *
     * @return null|mixed
     * @throws \DomainException
     */
    public static function create($className) {

        $parameterArray = [];

        if ($className[0] === '\\') {
            /** @var string $className */
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $className = substr($className, 1);

        }

        $classInstance = null;
        $class         = new \ReflectionClass($className);
        if ($class) {

            $constructor = $class->getConstructor();
            if ($constructor) {
                $parameterAll = $constructor->getParameters();

                foreach ($parameterAll as $parameter) {

                    if ($parameter) {
                        $typeHint = self::isTypeHintParameter($parameter);
                        $position = $parameter->getPosition();

                        if (isset(self::$classConfigurationArray[$className][$position])) {
                            $parameterArray[] = self::$classConfigurationArray[$className][$position];
                        } else {
                            if ($typeHint !== false) {
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
     * @param \ReflectionParameter $parameter
     *
     * @return bool
     */
    protected static function isTypeHintParameter(\ReflectionParameter $parameter) {

        $ret = false;

        $typeHintClass = $parameter->getClass();

        if (is_object($typeHintClass)) {
            $typeHint = $typeHintClass->name;
            if ($typeHint) {
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
    protected static function classNameHasTypeHints($className) {

        $ret = false;

        $class = new \ReflectionClass($className);
        if ($class) {
            $constructor = $class->getConstructor();
            if ($constructor) {
                $parameterAll = $constructor->getParameters();

                foreach ($parameterAll as $parameter) {
                    if ($parameter) {
                        $typeHint = self::isTypeHintParameter($parameter);

                        if ($typeHint !== false) {
                            $ret = true;
                        }
                    }
                }
            }
        }

        return $ret;
    }
}
