<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.19 at 01:47 MEZ
 */

/**
 * @param $className
 *
 * @return bool
 */
function culibraryAutoloader($className) {

    $success = false;

    $ds = DIRECTORY_SEPARATOR;
    $ns = '\\';

    $nameSpaceParts = explode($ns, $className);

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