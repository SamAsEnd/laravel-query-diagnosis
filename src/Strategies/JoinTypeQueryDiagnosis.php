<?php

namespace SamAsEnd\QueryDiagnosis\Strategies;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use SamAsEnd\QueryDiagnosis\Enums\JoinType;
use SamAsEnd\QueryDiagnosis\Exceptions\JoinTypeDiagnosisException;

class JoinTypeQueryDiagnosis extends QueryDiagnosisContract
{
    public function __construct(protected JoinType $joinType)
    {
        //
    }

    public function match(QueryExecuted $executedQuery, Collection $explainResult): bool
    {
        return $explainResult
            ->filter(fn ($result) => $result->type === $this->joinType->value)
            ->isNotEmpty();
    }

    public function report(QueryExecuted $executedQuery, Collection $explainResult): void
    {
        throw new JoinTypeDiagnosisException(
            $this->joinType,
            $executedQuery,
            $explainResult
        );
    }
}
