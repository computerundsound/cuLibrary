<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:53 MEZ
 */

use computerundsound\culibrary\db\mysqli\CuDBiResult;

require_once __DIR__ . '/includes/application.inc.php';

$message = 'DB-Example';

/** @var \computerundsound\culibrary\db\mysqli\CuDBi $cuDBi */
$cuDBi = \computerundsound\culibrary\db\mysqli\CuDBi::getInstance(new CuDBiResult(),
                                                                  DB_SERVER,
                                                                  DB_USERNAME,
                                                                  DB_PASSWORD,
                                                                  DB_DB_NAME);

$message =
    $cuDBi->connect_errno ? 'You need a DB to test the code in the Template: ' . $cuDBi->connect_error : $message;

/** @noinspection UnNecessaryDoubleQuotesInspection */
$createTestTable = <<<'SQL'
CREATE TABLE IF NOT EXISTS test
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    value VARCHAR(255) NOT NULL,
    info VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL
);
SQL;

$cuDBi->cuQuery($createTestTable);

$rand = mt_rand(0, 1000);

$insert = [

    'value'   => 'one Value: ' . $rand,
    'info'    => 'one Info: ' . $rand,
    'created' => date('Y-m-d H:i:s'),

];

$cuDBi->cuInsert('test', $insert);

$valuesInDB = $cuDBi->selectAsArray('test', '', 'created ASC');

$view->assign('valuesInDB', $valuesInDB);

//* ************************** Template Output *************************************************/

$view->assign('title', 'DB-Example');

$view->assign('message', $message);

$content = $view->fetch('dbtest');

$view->assign('content', $content);
$view->display('wrapper');