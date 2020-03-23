<?php /** @noinspection PhpUnused */
/** @noinspection PhpComposerExtensionStubsInspection */

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
    private $result;

    private $lastInsertId;

    /** @var  string */
    private $message;

    /** @var  string */
    private $query;


    public function getLastInsertId()
    {

        return $this->lastInsertId;
    }


    public function setLastInsertId($lastInsertId)
    {

        $this->lastInsertId = $lastInsertId;
    }

    public function getMessage()
    {

        return $this->message;
    }


    public function setMessage($message)
    {

        $this->message = $message;
    }


    /**
     * @return mysqli_result |
     */
    public function getResult()
    {

        return $this->result;
    }


    public function setResult($result)
    {

        $this->result = $result;
    }

    public function getQuery()
    {

        return $this->query;
    }

    public function setQuery($query)
    {

        $this->query = $query;
    }
}
