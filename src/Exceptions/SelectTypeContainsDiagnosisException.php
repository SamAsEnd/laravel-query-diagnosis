<?php

namespace SamAsEnd\QueryDiagnosis\Exceptions;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;

class SelectTypeContainsDiagnosisException extends GenericQueryDiagnosisException
{
    public function __construct(
        protected array|string $contains,
        QueryExecuted $executedQuery,
        Collection $explainResult
    ) {
        parent::__construct($executedQuery, $explainResult);
    }
}
