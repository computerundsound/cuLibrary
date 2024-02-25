<?php
declare(strict_types=1);

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

use computerundsound\culibrary\CuConstantsContainer;
use computerundsound\culibrary\CuMiniTemplateEngine;

require_once __DIR__ . '/../../culibincluder.start.php';

require_once __DIR__ . '/config.php';

$view = new CuMiniTemplateEngine(__DIR__ . '/../_templates/');

$view->assign('db_username', DB_USERNAME);
$view->assign('db_password', DB_PASSWORD);
$view->assign('db_server', DB_SERVER);
$view->assign('db_dbName', DB_DB_NAME);

/* CuConstants: */

$cuConstants = new CuConstantsContainer('/_examples/');

$cuConstantsArray['FilePathHTTP']  = $cuConstants->getFilePath_HTTP();
$cuConstantsArray['AppRootHTTP']   = $cuConstants->getAppRootHTTP();
$cuConstantsArray['AppRootFQHTTP'] = $cuConstants->getAppRootFQHTTP();
$cuConstantsArray['AppRootServer'] = $cuConstants->getAppRootServer();

$view->assign('cuConstants', $cuConstantsArray);

const CU_FLASH_STANDARD_MESSAGE = 'This Message has a livetime only for the next request. 
       This is very handy if you want to send a message to the browser just for the next request 
       (like: Data is saved, or there was an error i.e.)';