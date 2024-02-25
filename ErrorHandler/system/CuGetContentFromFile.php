<?php

namespace computerundsound\culibrary\ErrorHandler\system;

class CuGetContentFromFile
{
    const LINES_BEFORE = 10;
    const LINES_AFTER  = 7;

    protected string $filePath;
    protected int $line;

    public function __construct(string $filePath, int $line)
    {
        $this->filePath = $filePath;
        $this->line     = $line;

    }

    public function getLinesAsHtmlString(): string
    {

        $lines = $this->getLinesFromFile($this->filePath);

        $contentBlock = '';

        foreach ($lines as $lineNumber => $line) {
            $lineEncoded      = htmlspecialchars($line, ENT_HTML5);
            $lineNumberAddOne = $lineNumber + 1;
            if ($lineNumber + 1 === $this->line) {
                $contentBlock .= "<span style='color: #f80000;'>[$lineNumberAddOne] $lineEncoded</span>" . PHP_EOL;
            } else {
                $contentBlock .= "[$lineNumberAddOne] $lineEncoded" . PHP_EOL;
            }
        }

        return $contentBlock;

    }

    protected function getLinesFromFile($filePath): array
    {

        $lines = [];

        if (is_file($filePath) && !is_dir($this->filePath)) {
            $content = file_get_contents($this->filePath);
        }

        $lines         = explode("\n", $content);
        $relevantLines = $this->getLines($lines);

        return $relevantLines;
    }

    protected function getLines(array $lines): array
    {
        $relevantLines = [];

        $linesBefore = self::LINES_BEFORE;
        $linesAfter  = self::LINES_AFTER;
        $matchLine   = $this->line;
        $maxLines    = count($lines);

        $minLine = ($matchLine - $linesBefore) < 0 ? 0 : $matchLine - $linesBefore;
        $maxLine = (($matchLine + $linesBefore) > $maxLines) ? $maxLines : ($matchLine + $linesBefore);

        $currentLine = $minLine;
        while ($currentLine < $maxLine) {
            $relevantLines[$currentLine] = $lines[$currentLine];
            $currentLine++;
        }

        return $relevantLines;
    }
}