<?php
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection PhpUnhandledExceptionInspection */

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

declare(strict_types=1);

use computerundsound\culibrary\CuFlashMessage;
use computerundsound\culibrary\CuRequester;
use computerundsound\culibrary\db\mysqli\CuDBi;
use computerundsound\culibrary\db\mysqli\CuDBiResult;

require_once __DIR__ . '/includes/application.inc.php';

$message = 'DB-Example';

/** @var CuDBi $cuDBi */
$cuDBi = CuDBi::getInstance(new CuDBiResult(),
                            DB_SERVER,
                            DB_USERNAME,
                            DB_PASSWORD,
                            DB_DB_NAME);
$message
       = $cuDBi->connect_errno ? 'You need a DB to test the code in the Template: ' . $cuDBi->connect_error : $message;

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

$rand = random_int(0, 1000);

$insert = [

    'value'   => 'one Value: ' . $rand,
    'info'    => 'one Info: ' . $rand,
    'created' => date('Y-m-d H:i:s'),

];

$action = CuRequester::getGetPost('action');

if ($action === 'truncateTable') {

    $cuDBi->cuTruncateTab('test');

    CuFlashMessage::save('This massage was created, as you truncated the Table.<br><br>' . CU_FLASH_STANDARD_MESSAGE);
}

$cuDBi->cuInsert('test', $insert);

$valuesInDB = $cuDBi->cuSelectAsArray('test', '', 'created ASC');

$view->assign('valuesInDB', $valuesInDB);

//* ************************** Template Output *************************************************/

$view->assign('title', 'DB-Example');

$view->assign('message', $message);

$view->assign('currentPage', 'dbSample');

$content = $view->fetch('dbtest', false);

$view->assign('content', $content);
$view->display('wrapper');