<?php
declare(strict_types=1);
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

    public function getMessage(): string;

    public function setMessage(string $message);

    public function getQuery(): string;

    public function setQuery(string $query);
}
