<?php

/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

namespace computerundsound\culibrary\db;

/**
 * Class CuDBResult
 */
interface CuDBResult
{


    /**
     * @return mixed
     */
    public function getLastInsertId();

    /**
     * @param mixed $lastInsertId
     */
    public function setLastInsertId($lastInsertId);

    public function getMessage();

    public function setMessage($message);

    public function getQuery();

    public function setQuery($query);
}
