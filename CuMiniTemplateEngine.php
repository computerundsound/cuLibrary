<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.02.04 at 23:47 MEZ
 */

namespace computerundsound\culibrary;

use DomainException;

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
     * @throws DomainException
     */
    public function __construct($templateFolder)
    {

        $this->setTemplateFolder($templateFolder);
    }


    /**
     * @param $templateFolder
     *
     * @throws DomainException
     */
    public function setTemplateFolder($templateFolder)
    {

        if (is_dir($templateFolder) === false) {
            throw new DomainException("Template-Folder $templateFolder not found");
        }

        $this->templateFolder = $templateFolder;
    }


    /**
     * @param $name
     * @param $value
     */
    public function assign($name, $value)
    {

        $this->variablesForTemplate[$name] = $value;
    }

    /**
     * @param $template
     *
     * @throws DomainException
     */
    public function display($template)
    {

        $content = $this->fetch($template);

        echo $content;
    }

    /**
     * @param string $template
     * @param bool   $clearAssignments
     *
     * @return string
     * @throws DomainException
     */
    public function fetch($template, $clearAssignments = true)
    {

        extract($this->variablesForTemplate, EXTR_OVERWRITE);

        $template = $this->templateFolder . $template . '.template.php';

        if (file_exists($template) === false) {
            throw new DomainException('Template not found in ' . $template);
        }

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include $template;

        $content = ob_get_clean();

        if ($clearAssignments) {
            $this->variablesForTemplate = [];
        }

        return $content;
    }

    /**
     * @param string $name
     * @param bool   $html
     */
    public function showValue($name, $html = true)
    {

        $value = $this->getValue($name);

        if ($html) {
            $value = $this->getAsHtml($value);
        }

        echo $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getValue($name)
    {

        $returnValue = '';

        if (array_key_exists($name, $this->variablesForTemplate)) {
            $returnValue = $this->variablesForTemplate[$name];
        }

        return $returnValue;
    }

    /**
     * @param string $value
     */
    public function showAsHtml($value)
    {

        echo $this->getAsHtml($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function getAsHtml($value)
    {

        return htmlspecialchars($value, ENT_COMPAT, 'utf-8');
    }
}