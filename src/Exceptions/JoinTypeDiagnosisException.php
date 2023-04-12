<?php

namespace SamAsEnd\QueryDiagnosis\Exceptions;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use SamAsEnd\QueryDiagnosis\Enums\JoinType;

class JoinTypeDiagnosisException extends GenericQueryDiagnosisException
{
    public function __construct(public JoinType $joinType, QueryExecuted $executedQuery, Collection $explainResult)
    {
        parent::__construct($executedQuery, $explainResult);
    }
}
