<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 09.09.2016
 * Time: 22:23
 * 
 * Created by IntelliJ IDEA
 *
 */

/**
 * @param $classname
 *
 * @return bool
 */
function culibraryAutoloader($classname) {

    $success = false;

    $ds = DIRECTORY_SEPARATOR;
    $ns = '\\';

    $nameSpaceParts = explode($ns, $classname);

    $nameSpacePartsUsed = array_slice($nameSpaceParts, 2);

    $pathPart   = implode($ds, $nameSpacePartsUsed);
    $pathToFile = __DIR__ . $ds . $pathPart . '.php';

    if (file_exists($pathToFile)) {
        /** @noinspection PhpIncludeInspection */
        include_once $pathToFile;
        $success = true;
    }

    return $success;

}

spl_autoload_register('culibraryAutoloader');