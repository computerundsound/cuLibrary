<?php
/*
 * Copyright by J�rg Wrase - www.Computer-Und-Sound.de
 * Date: 10.05.2015
 * Time: 23:24
 * 
 * Created by IntelliJ IDEA
 *
 */

use computerundsound\culibrary\CuFactoryUtil;
use computerundsound\culibrary\CuMiniTemplateEngine;
use computerundsound\culibrary\db\pdo\CuDBpdo;
use computerundsound\culibrary\db\pdo\CuDBpdoResult;

require_once '../CuFactory.php';

require_once '../db/CuDB.php';
require_once '../db/CuDBResult.php';

require_once '../db/mysqli/CuDBi.php';
require_once '../db/mysqli/CuDBiResult.php';

require_once '../db/pdo/CuDBpdo.php';
require_once '../db/pdo/CuDBpdoResult.php';

$username = 'peng';
$password = 'peng';
$server   = 'localhost';
$dbName   = 'test';

$message = '';

/** @var CuDBpdo $mySqlObj */
$mySqlObj = CuDBpdo::getInstance(new CuDBpdoResult(), $server, $username, $password, $dbName);

$ret = $mySqlObj->getAttribute(PDO::ATTR_CLIENT_VERSION);

$tableName = 'testtable';

$dataInsertArray = ['vorname' => 'Kimbertimber', 'name' => 'Limberbimber', 'ort' => 'Zauberhausen'];

$mySqlObj->cuDelete($tableName, 'vorname LIKE \'Kimber%\'');

$mySqlObj->cuInsert($tableName, $dataInsertArray);

$dataUpdateArray = ['vorname' => 'Kimbertimber' . time()];
$mySqlObj->cuUpdate($tableName, $dataUpdateArray, '`vorname` LIKE \'Kimbertimber%\' LIMIT 2');

$message = 'Hier die Message';

$countDataSets = $mySqlObj->getQuantityOfDataSets($tableName);

$message = (string)$countDataSets;

/* ************************** Template ausgabe *************************************************/
$dataArray = $mySqlObj->selectAsArray($tableName);

require_once '../CuMiniTemplateEngine.php';

/** @var CuMiniTemplateEngine $cuMTE */
$cuMTE = CuFactoryUtil::create('curlibrary\CuMiniTemplateEngine');

$cuMTE->setTemplateFolder(__DIR__ . '/_templates/');

$cuMTE->assign('Title', 'Hier der Titel');
$cuMTE->assign('resultArray', $dataArray);

$cuMTE->assign('message', $message);

$cuMTE->display('dbtest');
