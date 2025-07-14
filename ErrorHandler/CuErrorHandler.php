<?php

namespace computerundsound\culibrary\ErrorHandler;

use computerundsound\culibrary\ErrorHandler\system\CuErrorHandlerParameter;
use computerundsound\culibrary\ErrorHandler\system\CuErrorType;
use JetBrains\PhpStorm\NoReturn;
use RuntimeException;
use Throwable;

/**
 *
 */
class CuErrorHandler
{

    /**
     * @var CuErrorHandler
     */
    protected static CuErrorHandler $instance;

    protected static ?string $mailToAddress = null;
    protected static ?string $mailFromAddress = null;
    protected static ?string $subject = null;

    protected static bool $showError = false;
    protected static bool $sendMail = false;

    protected static ?string $templateForErrorPath = __DIR__ . '/templateForError.php';
    protected static ?string $templateForNotShownErrorPath = __DIR__ . '/templateForNotShownError.php';

    /**
     * @return CuErrorHandler
     */
    public static function getInstance(bool $showError = false, $sendEmail = false): CuErrorHandler
    {

        $instance = new static();

        self::$showError = $showError;
        self::$sendMail  = $sendEmail;

        set_error_handler([$instance, 'cuErrorHandler']);
        set_exception_handler([$instance, 'cuExceptionHandler']);

        return $instance;

    }

    #[NoReturn]
    public function cuErrorHandler(int     $errorNo,
                                               string  $errorMsg,
                                               ?string $file = null,
                                               ?int    $line = null,
                                               ?array  $context = null): void
    {

        $errorParameter = new CuErrorHandlerParameter(CuErrorType::Error);
        $errorParameter->setMessage($errorMsg)->setFile($file)->setLine($line)->setContext($context);

        $this->handleTrigger($errorParameter, self::$showError, self::$sendMail);

        exit;

    }

    #[NoReturn]
    public function cuExceptionHandler(Throwable $throwable): void
    {

        $errorMsg = $throwable->getMessage();
        $file     = $throwable->getFile();
        $line     = $throwable->getLine();
        $stack    = $throwable->getTraceAsString();

        $errorParameter = new CuErrorHandlerParameter(CuErrorType::Exception);
        $errorParameter->setMessage($errorMsg)->setFile($file)->setLine($line);

        $this->handleTrigger($errorParameter, self::$showError, self::$sendMail);

        exit;

    }

    public function setMailToAddress(?string $mailToAddress): self
    {
        self::$mailToAddress = $mailToAddress;

        return $this;
    }

    public function setMailFromAddress(?string $mailFromAddress): self
    {
        self::$mailFromAddress = $mailFromAddress;

        return $this;
    }

    public function setSubject(?string $subject): self
    {
        self::$subject = $subject;

        return $this;
    }

    public function setTemplateForErrorPath(string $templateForErrorPath): self
    {
        $templateForErrorPathReal = realpath($templateForErrorPath);

        if (!is_file($templateForErrorPathReal)) {
            trigger_error('Template not found in ' . $templateForErrorPathReal);
        }

        self::$templateForErrorPath = $templateForErrorPathReal;

        return $this;
    }

    public function setTemplateForNotShownErrorPath(string $templateForNotShownErrorPath): self
    {
        $templateForNotShownErrorPathReal = realpath($templateForNotShownErrorPath);

        if (!is_file($templateForNotShownErrorPathReal)) {
            trigger_error('Template for not "Shown Error" not found in ' . $templateForNotShownErrorPathReal);
        }


        self::$templateForNotShownErrorPath = $templateForNotShownErrorPathReal;

        return $this;
    }

    protected function handleTrigger(CuErrorHandlerParameter $errorHandlerParameter,
                                     bool                    $showErrors = false,
                                     bool                    $sendMail = false): void
    {

        if ($showErrors) {
            $this->show($errorHandlerParameter);
        } else {
            $this->showIfNoErrorShouldBeShown($errorHandlerParameter);
        }

        if ($sendMail) {
            $this->mail($errorHandlerParameter);
        }

    }

    protected function show(CuErrorHandlerParameter $errorHandlerParameter): void
    {

        $content = $this->getTemplate($errorHandlerParameter, self::$templateForErrorPath);

        echo $content;
    }

    protected function mail(CuErrorHandlerParameter $errorHandlerParameter): void
    {

        if (self::$mailToAddress) {

            $content = $this->getTemplate($errorHandlerParameter, self::$templateForErrorPath);

            $header = 'MIME-Version: 1.0' . "\r\n";
            $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $header .= 'From: ' . self::$mailFromAddress;

            /** @noinspection PhpUsageOfSilenceOperatorInspection */
            $subject = self::$subject ?? 'Error on your Webpage';

            $return = @mail(self::$mailToAddress, $subject, $content, $header);

            if (!$return) {
                throw new RuntimeException('There was an Error while trying to send an email: ' .
                                           error_get_last()['message']);
            }

        }
    }

    protected function showIfNoErrorShouldBeShown(CuErrorHandlerParameter $errorHandlerParameter): void
    {

        $content = $this->getTemplate($errorHandlerParameter, self::$templateForNotShownErrorPath);

        echo $content;
    }

    /**
     * @param CuErrorHandlerParameter $errorHandlerParameter
     * @param string                  $pathToTemplate
     * @return string
     */
    protected function getTemplate(CuErrorHandlerParameter $errorHandlerParameter, string $pathToTemplate): string
    {

        $cuEHP = $errorHandlerParameter;

        ob_get_clean();
        ob_start();
        include($pathToTemplate);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }


}