<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2016.10.30 at 07:42 MEZ
 */

/*
 * Only use this file, if you don't have composer
 */

/**
 * @param $className
 *
 * @return bool
 */
function culibraryAutoloader($className)
{

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