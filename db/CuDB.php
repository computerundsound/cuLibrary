<?php
declare(strict_types=1);
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 */

namespace computerundsound\culibrary\db;

/**
 * Interface CuDB
 */
interface CuDB
{


    public function cuTruncateTab(string $tableName);

    public function cuDeleteOneDataSet(string $tableName, string $idName, $idValue): void;

    public function cuDelete(string $tableName, string $where): CuDBResult;

    public function cuQuery(string $query): CuDBResult;

    public function cuInsert(string $tableName, array $assocDataArray): CuDBResult;

    public function cuUpdateOneDataSet(string $tableName, array $assocDataArray, string $idName, $id): CuDBResult;

    public function cuUpdate(string $tableName, array $assocDataArray, string $where): CuDBResult;

    public function cuSelectOneDataSet(string $tableName, string $fieldName, $fieldValue): array;

    public function cuSelectAsArray(string $tableName,
                                    string $where = '',
                                    string $order = '',
                                    string $limit = ''): array;

    public function cuGetQuantityOfDataSets(string $tableName): int;

    public function cuGetColNamesFromTable(string $tableName): array;

    public function cuCloseConnection(): void;

    public function cuGetFieldInfo(string $tableName, string $fieldName): object;
}