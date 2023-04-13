<?php

namespace SamAsEnd\QueryDiagnosis\Strategies;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;

abstract class QueryDiagnosisContract
{
    abstract public function match(QueryExecuted $executedQuery, Collection $explainResult): bool;

    abstract public function report(QueryExecuted $executedQuery, Collection $explainResult): void;
}
