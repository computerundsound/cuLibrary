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
use curlibrary\CuFactory;

require_once '../CuFactory.class.php';

require_once '../db/CuDB.interface.php';
require_once '../db/CuDBResult.interface.php';

require_once '../db/mysqli/CuDBi.class.php';
require_once '../db/mysqli/CuDBiResult.class.php';

$username = 'peng';
$password = 'peng';
$server   = 'localhost';
$dbName   = 'test';

/** @var CuDBi $mySqlObj */
$mySqlObj = CuDBi::getInstance(new CuDBiResult(), $server, $username, $password, $dbName);

$ret = $mySqlObj->client_info;

$tableName = 'testtable';

$dataInsertArray = ['vorname' => 'Kimbertimber', 'name' => 'Limberbimber', 'ort' => 'Zauberhausen'];

$mySqlObj->cuInsert($tableName, $dataInsertArray);

$dataUpdateArray = ['vorname' => 'Kimbertimber' . time()];
$mySqlObj->cuUpdate($tableName, $dataUpdateArray, '`vorname` = \'Kimbertimber\' LIMIT 2');

/* ************************** Template ausgabe *************************************************/
$dataArray = $mySqlObj->selectAsArray($tableName);

require_once '../CuMiniTemplateEngine.php';

/** @var \curlibrary\CuMiniTemplateEngine $cuMTE */
$cuMTE = CuFactory::create('curlibrary\CuMiniTemplateEngine');

$cuMTE->setTemplateFolder(__DIR__ . '/_templates/');

$cuMTE->assign('Title', 'Hier der Titel');
$cuMTE->assign('resultArray', $dataArray);

$cuMTE->display('dbtest');
