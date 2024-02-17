<?php /** @noinspection PhpUnused */
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

namespace computerundsound\culibrary;

use DomainException;

class CuMiniTemplateEngine
{

    private array $variablesForTemplate = [];

    private string $templateFolder = '';


    public function __construct(string $templateFolder)
    {

        $this->setTemplateFolder($templateFolder);
    }


    public function setTemplateFolder(string $templateFolder): void
    {

        if (is_dir($templateFolder) === false) {
            throw new DomainException("Template-Folder $templateFolder not found");
        }

        $this->templateFolder = $templateFolder;
    }


    /**
     * @param string $name
     * @param mixed  $value
     */
    public function assign(string $name, $value): void
    {

        $this->variablesForTemplate[$name] = $value;
    }

    public function display(string $template): void
    {

        $content = $this->fetch($template);

        echo $content;
    }

    public function fetch(string $template, bool $clearAssignments = true): string
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

    public function showValue(string $name, bool $html = true): void
    {

        $value = $this->getValue($name);

        if ($html) {
            $value = $this->getAsHtml($value);
        }

        echo $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getValue(string $name)
    {

        $returnValue = '';

        if (array_key_exists($name, $this->variablesForTemplate)) {
            $returnValue = $this->variablesForTemplate[$name];
        }

        return $returnValue;
    }

    public function showAsHtml(string $value): void
    {

        echo $this->getAsHtml($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function getAsHtml(string $value): string
    {

        return htmlspecialchars($value, ENT_COMPAT, 'utf-8');
    }
}