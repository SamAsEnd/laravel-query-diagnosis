<?php

namespace SamAsEnd\QueryDiagnosis\Exceptions;

use RuntimeException;

class UnsupportedDatabaseDriverException extends RuntimeException
{
    public function __construct(string $driver)
    {
        parent::__construct("Only support mysql driver for now. ({$driver}) given.");
    }
}
