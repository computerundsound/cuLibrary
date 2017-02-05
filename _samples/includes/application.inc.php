<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:35 MEZ
 */

require_once __DIR__ . '/../../culibincluder.start.php';

$view = new \computerundsound\culibrary\CuMiniTemplateEngine(__DIR__ . '/../_templates/');

define('DB_USERNAME', 'curlibrary_username');
define('DB_PASSWORD', 'curlibrary_password');
define('DB_SERVER', 'localhost');
define('DB_DB_NAME', 'curlibrary_dbName');

$view->assign('db_username', DB_USERNAME);
$view->assign('db_password', DB_PASSWORD);
$view->assign('db_server', DB_SERVER);
$view->assign('db_dbName', DB_DB_NAME);