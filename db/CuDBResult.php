<?php
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
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
    public function getLastInsertId(): mixed;

    /**
     * @param mixed $lastInsertId
     */
    public function setLastInsertId(mixed $lastInsertId);

    public function getMessage(): string;

    public function setMessage(string $message);

    public function getQuery(): string;

    public function setQuery(string $query);
}
