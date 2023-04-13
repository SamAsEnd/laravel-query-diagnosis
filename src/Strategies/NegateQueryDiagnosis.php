<?php

namespace SamAsEnd\QueryDiagnosis\Strategies;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;

class NegateQueryDiagnosis extends QueryDiagnosisContract
{
    public function __construct(protected QueryDiagnosisContract $queryDiagnosis)
    {
        //
    }

    public function match(QueryExecuted $executedQuery, Collection $explainResult): bool
    {
        return ! $this->queryDiagnosis->match($executedQuery, $explainResult);
    }

    public function report(QueryExecuted $executedQuery, Collection $explainResult): void
    {
        $this->queryDiagnosis->report($executedQuery, $explainResult);
    }
}
