<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.19 at 02:17 MEZ
 */

use computerundsound\culibrary\CuMiniTemplateEngine;

/* include autoloader for this library - better use composer! */
require_once __DIR__ . '/../culibincluder.start.php';

/* DB Data */
$username = 'peng';
$password = 'peng';
$server   = 'localhost';
$dbName   = 'test';

$message = 'You need a DB to test the code in the Template';

$smallArray = [
    'Key One' => 'Value One',
    'Key Two' => 'Value Two',
];

$smallObj      = new stdClass();
$smallObj->one = 'Value One from Object';
$smallObj->two = 'Value Two from Object';

$codeblock = <<<'HTML'

/* Only an Example - you need a DB to run this example

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


HTML;

//* ************************** Template Output *************************************************/

$view = new CuMiniTemplateEngine();
$view->setTemplateFolder(__DIR__ . '/_templates/');

$view->assign('title', 'This is the Title');
$view->assign('message', $message);
$view->assign('codeblock', $codeblock);
$view->assign('smallArray', $smallArray);
$view->assign('smallObj', $smallObj);

$content = $view->fetch('dbtest');

$view->assign('content', $content);
$view->display('wrapper');