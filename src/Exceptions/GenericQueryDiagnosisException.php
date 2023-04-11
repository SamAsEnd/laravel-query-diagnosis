<?php

namespace SamAsEnd\QueryDiagnosis\Exceptions;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use RuntimeException;
use Throwable;

class GenericQueryDiagnosisException extends RuntimeException
{
    public function __construct(
        public QueryExecuted $executedQuery,
        public Collection $explainResult,
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
