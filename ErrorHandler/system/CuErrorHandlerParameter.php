<?php

namespace computerundsound\culibrary\ErrorHandler\system;

class CuErrorHandlerParameter
{

    private ?string $referer = null;
    private ?string $codeBlock = null;
    private CuErrorType $errorType;
    private ?int $number = null;
    private ?string $message = null;
    private ?string $stack = null;
    private bool $hasStack = false;
    private ?string $file = null;
    private ?int $line = null;
    private ?array $context = null;

    public function __construct(CuErrorType $errorType)
    {
        $this->errorType = $errorType;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): CuErrorHandlerParameter
    {
        $this->number = $number;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): CuErrorHandlerParameter
    {
        $this->message = $message;
        return $this;
    }

    public function getStack(): ?string
    {
        return $this->stack;
    }

    public function setStack(string $stack): CuErrorHandlerParameter
    {
        $this->stack = $stack;
        return $this;
    }

    public function getCodeBlock(): ?string
    {
        if ($this->codeBlock === null) {
            $this->codeBlock = $this->buildCodeBlock();
        }

        return $this->codeBlock;
    }

    public function hasStack(): bool
    {
        return $this->hasStack;
    }

    public function setHasStack(bool $hasStack): CuErrorHandlerParameter
    {
        $this->hasStack = $hasStack;
        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): CuErrorHandlerParameter
    {
        $this->file = $file;
        return $this;
    }

    public function getLine(): ?int
    {
        return $this->line;
    }

    public function setLine(int $line): CuErrorHandlerParameter
    {
        $this->line = $line;
        return $this;
    }

    public function getErrorType(): string
    {
        return $this->errorType->name;
    }

    public function getReferer(): ?string
    {
        if ($this->referer === null) {
            $this->referer = $this->buildReferer();
        }

        return $this->referer;
    }

    protected function buildCodeBlock(): string
    {
        $cuGetContentFromFile = new CuGetContentFromFile($this->file, $this->line);

        $htmlString = $cuGetContentFromFile->getLinesAsHtmlString();

        return $htmlString;


    }

    protected function buildReferer(): string
    {

        $this->referer = $this->referer ?: ($_SERVER['HTTP_REFERER'] ?? '/');

        return $this->referer;


    }

    public function getContext(): ?array
    {
        return $this->context;
    }

    public function setContext(?array $context): CuErrorHandlerParameter
    {
        $this->context = $context;
        return $this;
    }



}