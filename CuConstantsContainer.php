<?php /** @noinspection PhpUnused */
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

namespace computerundsound\culibrary;

/**
 * Class CuConstantsContainer
 */
class CuConstantsContainer
{

    private string $appRoot_HTTP;

    private string $appRoot_Server;

    private string $appRoot_FQHTTP;

    private string $filePath_HTTP;

    private string $server_ServerName = '';

    private string $server_documentRoot = '';

    private string $server_phpSelf = '';

    private string $server_protocol = '';

    private string $pathFromDocRootToAppRoot;


    public function __construct(string $pathFromDocRootToAppRoot)
    {

        $this->pathFromDocRootToAppRoot = $pathFromDocRootToAppRoot;

        $this->buildServerValues();

        $this->buildAppRootHTTP();
        $this->buildAppRootServer();
        $this->buildAppRootFQHTTP();
        $this->buildFilePathHTTP();
    }

    public static function makeGoodPathServer(string $path): string
    {

        $path = str_replace(['\\', '/',], DIRECTORY_SEPARATOR, $path);

        return $path;
    }

    public static function makeGoodPathHTTP(string $path): string
    {

        $path = (string)str_replace('\\', '/', $path);


        return $path;
    }

    private static function makeUniversal(string $path): string
    {

        $replaced = str_replace('\\', '/', $path) ?: $path;

        $path = is_array($replaced) ? '' : $replaced;

        return $path;
    }


    private static function killLastSlash(string $path): string
    {

        $pathWithoutLastSlash = rtrim($path, '/');

        return $pathWithoutLastSlash;
    }

    public function getFilePath_HTTP(): string
    {

        return $this->filePath_HTTP;
    }

    public function getAppRootHTTP(): string
    {

        return $this->appRoot_HTTP;
    }

    public function getAppRootFQHTTP(): string
    {

        return $this->appRoot_FQHTTP;
    }

    public function getAppRootServer(): string
    {

        return $this->appRoot_Server;
    }

    public function getPathFromDocRootToAppRoot(): string
    {

        return $this->pathFromDocRootToAppRoot;
    }

    public function setPathFromDocRootToAppRoot(string $pathFromDocRootToAppRoot): void
    {

        $this->pathFromDocRootToAppRoot = $pathFromDocRootToAppRoot;
    }

    private function buildServerValues(): void
    {

        $this->server_ServerName = isset($_SERVER['SERVER_NAME']) ? (string)$_SERVER['SERVER_NAME'] : '';
        $this->server_documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? (string)$_SERVER['DOCUMENT_ROOT'] : '';
        $this->server_phpSelf = isset($_SERVER['PHP_SELF']) ? (string)$_SERVER['PHP_SELF'] : '';
        $this->server_protocol = $this->getProtocol();
    }

    private function getProtocol(): string
    {

        $port = isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 80;

        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            $port === 443) ?
            'https://' : 'http://';


    }

    private function buildAppRootHTTP(): void
    {

        $appRoot = $this->pathFromDocRootToAppRoot;

        $appRoot = self::makeUniversal($appRoot);

        $appRoot = $appRoot ?: '/';

        $this->appRoot_HTTP = $appRoot;
    }

    private function buildAppRootServer(): void
    {

        $docRoot = $this->server_documentRoot;
        $docRoot = self::makeUniversal($docRoot);

        $docRoot = self::killLastSlash($docRoot);
        $appRoot = $docRoot . $this->pathFromDocRootToAppRoot;

        $this->appRoot_Server = self::makeGoodPathServer($appRoot);
    }

    private function buildAppRootFQHTTP(): void
    {

        $method = $this->server_protocol;
        $method = substr($method, 0, 4);
        $method = strtoupper($method);

        $protocol = 'http://';
        if ($method === 'HTTPS') {
            $protocol = 'https://';
        }

        $url = $protocol . $this->server_ServerName;

        $app_root = $this->appRoot_HTTP;

        $this->appRoot_FQHTTP = $url . $app_root;
    }

    private function buildFilePathHTTP(): void
    {

        $this->buildAppRootHTTP();
        $filePathHTTP = self::killLastSlash($this->appRoot_FQHTTP);
        $filePathHTTP .= $this->server_phpSelf;
        $this->filePath_HTTP = $filePathHTTP;
    }


}