<?php

namespace SamAsEnd\QueryDiagnosis\Strategies;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;

abstract class QueryDiagnosisContract
{
    public abstract function match(QueryExecuted $executedQuery, Collection $explainResult): bool;

    public abstract function report(QueryExecuted $executedQuery, Collection $explainResult): void;
}
