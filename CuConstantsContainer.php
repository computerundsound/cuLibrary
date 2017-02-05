<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.05 at 02:48 MEZ
 */

namespace computerundsound\culibrary;

/**
 * Class CuConstantsContainer
 */
class CuConstantsContainer
{

    /**
     * @var
     */
    private $appRoot_HTTP;
    /**
     * @var
     */
    private $appRoot_Server;
    /**
     * @var
     */
    private $appRoot_FQHTTP;
    /**
     * @var
     */
    private $filePath_HTTP;

    /**
     * @var string
     */
    private $server_ServerName = '';
    /**
     * @var string
     */
    private $server_documentRoot = '';
    /**
     * @var string
     */
    private $server_phpSelf = '';
    /**
     * @var string
     */
    private $server_protocol = '';
    /** @var string */
    private $pathFromDocRootToAppRoot;


    /**
     * @param $pathFromDocRootToAppRoot
     */
    public function __construct($pathFromDocRootToAppRoot) {

        $this->pathFromDocRootToAppRoot = (string)$pathFromDocRootToAppRoot;

        $this->buildServerValues();

        $this->buildAppRootHTTP();
        $this->buildAppRootServer();
        $this->buildAppRootFQHTTP();
        $this->buildFilePathHTTP();
    }

    private function buildServerValues() {

        $this->server_ServerName   = isset($_SERVER['SERVER_NAME']) ? (string)$_SERVER['SERVER_NAME'] : '';
        $this->server_documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? (string)$_SERVER['DOCUMENT_ROOT'] : '';
        $this->server_phpSelf      = isset($_SERVER['PHP_SELF']) ? (string)$_SERVER['PHP_SELF'] : '';
        $this->server_protocol     = $this->getProtocol();
    }

    /**
     * @return string
     */
    private function getProtocol() {

        $protocol =
            ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (int)$_SERVER['SERVER_PORT'] === 443) ?
                'https://' : 'http://';

        return $protocol;

    }

    /**
     *
     */
    private function buildAppRootHTTP() {

        $appRoot = $this->pathFromDocRootToAppRoot;

        $appRoot = self::makeUniversal($appRoot);

        $appRoot = $appRoot ?: '/';

        $this->appRoot_HTTP = $appRoot;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private static function makeUniversal($path) {

        $path = str_replace('\\', '/', $path) ?: $path;

        return $path;
    }

    /**
     *
     */
    private function buildAppRootServer() {

        $docRoot = $this->server_documentRoot;
        $docRoot = self::makeUniversal($docRoot);

        $docRoot = self::killLastSlash($docRoot);
        $appRoot = $docRoot . $this->pathFromDocRootToAppRoot;

        $this->appRoot_Server = self::makeGoodPathServer($appRoot);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private static function killLastSlash($path) {

        $path = substr($path, -1) ? substr($path, 0, -1) : $path;

        return (string)$path;
    }

    /**
     * @param $path
     *
     * @return string
     */
    public static function makeGoodPathServer($path) {

        $path = (string)$path;
        $path = str_replace(['\\', '/',], DIRECTORY_SEPARATOR, $path);

        return $path;
    }

    /**
     *
     */
    private function buildAppRootFQHTTP() {

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

    /**
     *
     */
    private function buildFilePathHTTP() {

        $this->buildAppRootHTTP();
        $filePathHTTP        = self::killLastSlash($this->appRoot_FQHTTP);
        $filePathHTTP        .= $this->server_phpSelf;
        $this->filePath_HTTP = $filePathHTTP;
    }

    /**
     * @param $path
     *
     * @return string
     */
    public static function makeGoodPathHTTP($path) {

        $path = (string)$path;
        $path = str_replace('\\', '/', $path);
        $path = (string)$path;

        return $path;
    }

    /**
     * @return string
     */
    public function getFilePath_HTTP() {

        return $this->filePath_HTTP;
    }

    /**
     * @return string
     */
    public function getAppRootHTTP() {

        return $this->appRoot_HTTP;
    }

    /**
     * @return string
     */
    public function getAppRootFQHTTP() {

        return $this->appRoot_FQHTTP;
    }

    /**
     * @return string
     */
    public function getAppRootServer() {

        return $this->appRoot_Server;
    }

    /**
     * @return string
     */
    public function getPathFromDocRootToAppRoot() {

        return $this->pathFromDocRootToAppRoot;
    }

    /**
     * @param string $pathFromDocRootToAppRoot
     */
    public function setPathFromDocRootToAppRoot($pathFromDocRootToAppRoot) {

        $this->pathFromDocRootToAppRoot = $pathFromDocRootToAppRoot;
    }


}