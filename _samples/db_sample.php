<?php
/*
 * Copyright by J�rg Wrase - www.Computer-Und-Sound.de
 * Date: 10.05.2015
 * Time: 23:24
 * 
 * Created by IntelliJ IDEA
 *
 */

use culibrary\db\mysqli\CuDBi;
use culibrary\db\mysqli\CuDBiResult;

require_once '../db/CuDB.interface.php';
require_once '../db/CuDBResult.interface.php';

require_once '../db/mysqli/CuDBi.class.php';
require_once '../db/mysqli/CuDBiResult.class.php';

$username = 'peng';
$password = 'peng';
$server   = 'localhost';
$dbName   = 'test';

$mySqlObj = CuDBi::getInstance(new CuDBiResult(), $server, $username, $password, $dbName);

$ret = $mySqlObj->client_info;

var_dump($ret);


//$tableName = 'testtable';
//
//$dataInsertArray = ['vorname' => 'Kimbertimber', 'name' => 'Limberbimber', 'ort' => 'Zauberhausen'];
//
////$dbObj->cuInsert($tableName, $dataInsertArray);
//
//$dbObj->cuUpdate($tableName, $dataInsertArray, ['vorname' => '']);
//
///* ************************** Template ausgabe *************************************************/
//$dataArray = $dbObj->selectAsArray($tableName);
//
//require_once '../CuMiniTemplateEngine.php';
//$cuMTE = new cuMiniTemplateEngine(__DIR__ . '/_templates/');
//
//
//$cuMTE->assign('Title', 'Hier der Titel');
//$cuMTE->assign('resultArray', $dataArray);
//
//$cuMTE->display('dbtest');
