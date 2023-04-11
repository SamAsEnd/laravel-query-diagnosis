<?php

namespace SamAsEnd\QueryDiagnosis\Exceptions;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use SamAsEnd\QueryDiagnosis\Enums\SelectType;

class SelectTypeDiagnosisException extends GenericQueryDiagnosisException
{
    public function __construct(
        protected SelectType $joinType,
        QueryExecuted $executedQuery,
        Collection $explainResult
    ) {
        parent::__construct($executedQuery, $explainResult);
    }
}
