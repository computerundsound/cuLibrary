<?php /** @noinspection PhpUnused */

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

namespace computerundsound\culibrary;

use http\Exception\RuntimeException;

/**
 * Class CuConstantsContainer
 */
class CuConstantsContainer
{


    private $appRoot_HTTP;

    private $appRoot_Server;

    private $appRoot_FQHTTP;

    private $filePath_HTTP;

    private $server_ServerName = '';

    private $server_documentRoot = '';

    private $server_phpSelf = '';

    private $server_protocol = '';

    private $pathFromDocRootToAppRoot;


    public function __construct($pathFromDocRootToAppRoot)
    {

        $this->pathFromDocRootToAppRoot = $pathFromDocRootToAppRoot;

        $this->buildServerValues();

        $this->buildAppRootHTTP();
        $this->buildAppRootServer();
        $this->buildAppRootFQHTTP();
        $this->buildFilePathHTTP();
    }

    public static function makeGoodPathServer($path)
    {

        $path = str_replace(['\\', '/',], DIRECTORY_SEPARATOR, $path);

        return $path;
    }

    public static function makeGoodPathHTTP($path)
    {

        $path = str_replace('\\', '/', $path);
        $path = (string)$path;

        return $path;
    }

    private static function makeUniversal($path)
    {

        $path = str_replace('\\', '/', $path) ?: $path;

        return $path;
    }


    private static function killLastSlash($path)
    {

        $pathWithoutLastSlash = rtrim($path, '/');

        if ($pathWithoutLastSlash === false) {
            throw new RuntimeException('Could not remove last sign from String');
        }

        return $pathWithoutLastSlash;
    }

    public function getFilePath_HTTP()
    {

        return $this->filePath_HTTP;
    }

    public function getAppRootHTTP()
    {

        return $this->appRoot_HTTP;
    }

    public function getAppRootFQHTTP()
    {

        return $this->appRoot_FQHTTP;
    }

    public function getAppRootServer()
    {

        return $this->appRoot_Server;
    }

    public function getPathFromDocRootToAppRoot()
    {

        return $this->pathFromDocRootToAppRoot;
    }

    public function setPathFromDocRootToAppRoot($pathFromDocRootToAppRoot)
    {

        $this->pathFromDocRootToAppRoot = $pathFromDocRootToAppRoot;
    }

    private function buildServerValues()
    {

        $this->server_ServerName   = isset($_SERVER['SERVER_NAME']) ? (string)$_SERVER['SERVER_NAME'] : '';
        $this->server_documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? (string)$_SERVER['DOCUMENT_ROOT'] : '';
        $this->server_phpSelf      = isset($_SERVER['PHP_SELF']) ? (string)$_SERVER['PHP_SELF'] : '';
        $this->server_protocol     = $this->getProtocol();
    }

    private function getProtocol()
    {

        $port = isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 80;

        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                $port === 443) ?
            'https://' : 'http://';


    }

    private function buildAppRootHTTP()
    {

        $appRoot = $this->pathFromDocRootToAppRoot;

        $appRoot = self::makeUniversal($appRoot);

        $appRoot = $appRoot ?: '/';

        $this->appRoot_HTTP = $appRoot;
    }

    private function buildAppRootServer()
    {

        $docRoot = $this->server_documentRoot;
        $docRoot = self::makeUniversal($docRoot);

        $docRoot = self::killLastSlash($docRoot);
        $appRoot = $docRoot . $this->pathFromDocRootToAppRoot;

        $this->appRoot_Server = self::makeGoodPathServer($appRoot);
    }

    private function buildAppRootFQHTTP()
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

    private function buildFilePathHTTP()
    {

        $this->buildAppRootHTTP();
        $filePathHTTP        = self::killLastSlash($this->appRoot_FQHTTP);
        $filePathHTTP        .= $this->server_phpSelf;
        $this->filePath_HTTP = $filePathHTTP;
    }


}