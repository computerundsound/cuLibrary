<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.19 at 01:47 MEZ
 */

namespace computerundsound\culibrary;

/**
 * Class CuMiniTemplateEngine
 *
 * @package curlibrary
 */
class CuMiniTemplateEngine
{

    private $variablesForTemplate = [];

    private $templateFolder = '';

    /**
     * CuMiniTemplateEngine constructor.
     *
     * @param string $templateFolder
     *
     * @throws \DomainException
     */
    public function __construct($templateFolder) {

        $this->setTemplateFolder($templateFolder);

    }


    /**
     * @param $templateFolder
     *
     * @throws \DomainException
     */
    public function setTemplateFolder($templateFolder) {

        if (is_dir($templateFolder) === false) {
            throw new \DomainException("Template-Folder $templateFolder not found");
        }

        $this->templateFolder = $templateFolder;
    }


    /**
     * @param $name
     * @param $value
     */
    public function assign($name, $value) {

        $this->variablesForTemplate[$name] = $value;
    }

    /**
     * @param string $template
     * @param bool   $clearAssignments
     *
     * @return string
     * @throws \DomainException
     */
    public function fetch($template, $clearAssignments = true) {

        extract($this->variablesForTemplate, EXTR_SKIP);

        $template = $this->templateFolder . $template . '.template.php';

        if (file_exists($template) === false) {
            throw new \DomainException('Template not found in ' . $template);
        }

        $content = $this->sendToBrowser($template);

        if ($clearAssignments) {
            $this->variablesForTemplate = [];
        }

        return $content;
    }

    /**
     * @param $template
     *
     * @throws \DomainException
     */
    public function display($template) {

        $content = $this->fetch($template);

        echo $content;
    }


    /**
     * @param $name
     *
     * @return mixed
     */
    public function getValue($name) {

        $returnValue = '';

        if (array_key_exists($name, $this->variablesForTemplate)) {
            $returnValue = $this->variablesForTemplate[$name];
        }

        return $returnValue;
    }


    /**
     * @param      $name
     * @param bool $html
     */
    public function showValue($name, $html = false) {

        $value = $this->getValue($name);

        if ($html) {
            $value = htmlspecialchars($html, ENT_COMPAT, 'utf-8');
        }

        echo $value;
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function sendToBrowser($template) {

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include $template;

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}