<?php /** @noinspection PhpUnused */
/** @noinspection PhpComposerExtensionStubsInspection */
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
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

    /** @var  mysqli_result */
    private mysqli_result $result;

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


    /**
     * @return mysqli_result | bool
     */
    public function getResult()
    {

        return $this->result;
    }


    public function setResult($result): void
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
