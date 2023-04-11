<?php

namespace SamAsEnd\QueryDiagnosis\Strategies;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use SamAsEnd\QueryDiagnosis\Enums\SelectType;
use SamAsEnd\QueryDiagnosis\Exceptions\SelectTypeDiagnosisException;

class SelectTypeQueryDiagnosis extends QueryDiagnosisContract
{
    public function __construct(protected SelectType $selectType)
    {
        //
    }

    public function match(QueryExecuted $executedQuery, Collection $explainResult): bool
    {
        return $explainResult
            ->filter(fn($result) => $result->select_type === $this->selectType->value)
            ->isNotEmpty();
    }

    public function report(QueryExecuted $executedQuery, Collection $explainResult): void
    {
        throw new SelectTypeDiagnosisException(
            $this->selectType,
            $executedQuery,
            $explainResult
        );
    }
}
