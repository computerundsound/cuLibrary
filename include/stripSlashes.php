<?php
declare(strict_types=1);

/** @var mixed $value */

/** @noinspection PhpDeprecationInspection */
if (get_magic_quotes_gpc()) {
    $value = is_array($value) ? array_map([__CLASS__, 'stripSlashesDeep'], $value) : stripcslashes($value);
}