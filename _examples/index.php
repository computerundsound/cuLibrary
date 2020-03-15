<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */
declare(strict_types=1);

use computerundsound\culibrary\CuFlashMessage;
use computerundsound\culibrary\CuInfoMail;
use computerundsound\culibrary\CuMiniTemplateEngine;
use computerundsound\culibrary\CuRequester;

require_once __DIR__ . '/includes/application.inc.php';
/** @var CuMiniTemplateEngine $view */

$action = CuRequester::getGetPost('action');

switch ($action) {
    case 'phpinfo':
        /** @noinspection ForgottenDebugOutputInspection */
        phpinfo();
        exit;
        break;
    case 'showFlash':
        CuFlashMessage::save('This flashMessage is here, because you started an request for it.<br><br>' .
                             CU_FLASH_STANDARD_MESSAGE);
        break;
    case 'sendMail':

        $email = CuRequester::getGetPost('email');

        $cuMailer = new CuInfoMail($email, 'example@example.example_no_tld', 'Name From');
        $cuMailer->addRow('This is a extra row', 'This is the extra data');

        try {
            $cuMailer->sendEmail();
            CuFlashMessage::save("You have send an email to <strong>$email</strong>");
        } catch (Exception $e) {

            CuFlashMessage::save($e->getMessage());

        }


        break;
}

$view->assign('title', 'Some Examples');
$view->assign('currentPage', 'start');

$valueFromPostOrFromSession = CuRequester::getGetPostSession('valueFromPostOrFromSession') ?: '';

$view->assign('valueFromPostOrFromSession', $valueFromPostOrFromSession);

$userData = CuRequester::getClientData();

$view->assign('thisIsAnExampleArray', $userData);

/*
 * Assign an Object
 */
$smallObj      = new stdClass();
$smallObj->one = 'Value One from Object';
$smallObj->two = 'Value Two from Object';

$view->assign('myObject', $smallObj);

/* Fetch Content from subtemplates */
$content = $view->fetch('index', false);
$content .= $view->fetch('cuConstantsContainer', false);


$view->assign('content', $content);
$view->display('wrapper');
