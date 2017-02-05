<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 06:10 MEZ
 */

use computerundsound\culibrary\CuRequester;

require_once __DIR__ . '/includes/application.inc.php';
/** @var \computerundsound\culibrary\CuMiniTemplateEngine $view */

$view->assign('title', 'Some Example');

$valueFromPostOrFromSession = CuRequester::getPostSession('valueFromPostOrFromSession') ?: '';

$view->assign('valueFromPostOrFromSession', $valueFromPostOrFromSession);

$thisIsAnExampleArray = [
    'one',
    'two',
    'three',
];
$view->assign('thisIsAnExampleArray', $thisIsAnExampleArray);

$smallObj      = new stdClass();
$smallObj->one = 'Value One from Object';
$smallObj->two = 'Value Two from Object';

$view->assign('myObject', $smallObj);

$content = $view->fetch('index');

/* CuConstants: */

$cuConstants = new \computerundsound\culibrary\CuConstantsContainer('/_samples/');

$cuConstantsArray['FilePathHTTP']  = $cuConstants->getFilePath_HTTP();
$cuConstantsArray['AppRootHTTP']   = $cuConstants->getAppRootHTTP();
$cuConstantsArray['AppRootFQHTTP'] = $cuConstants->getAppRootFQHTTP();
$cuConstantsArray['AppRootServer'] = $cuConstants->getAppRootServer();

$view->assign('cuConstants', $cuConstantsArray);

$content .= $view->fetch('cuConstantsContainer');

$view->assign('content', $content);
$view->display('wrapper');

