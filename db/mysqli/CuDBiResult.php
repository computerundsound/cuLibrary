<?php /** @noinspection PhpUnused */
/** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 */

namespace computerundsound\culibrary\db\mysqli;

use computerundsound\culibrary\db\CuDBResult;
use mysqli_result;

/**
 * Class CuDBiResult
 */
class CuDBiResult implements CuDBResult
{

    private mysqli_result|bool|null $result = null;

    private int $lastInsertId;

    /** @var  string */
    private string $message;

    /** @var  string */
    private string $query;


    public function getLastInsertId(): int
    {

        return $this->lastInsertId;
    }


    public function setLastInsertId($lastInsertId): void
    {

        $this->lastInsertId = $lastInsertId;
    }

    public function getMessage(): string
    {

        return $this->message;
    }


    public function setMessage(string $message): void
    {

        $this->message = $message;
    }


    public function getResult(): mysqli_result|bool|null
    {

        return $this->result;
    }


    public function setResult(mysqli_result|bool $result): void
    {

        $this->result = $result;
    }

    public function getQuery(): string
    {

        return $this->query;
    }

    public function setQuery(string $query): void
    {

        $this->query = $query;
    }
}
