<?php

namespace SamAsEnd\QueryDiagnosis\Strategies;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SamAsEnd\QueryDiagnosis\Exceptions\SelectTypeContainsDiagnosisException;

class SelectTypeContainsQueryDiagnosis extends QueryDiagnosisContract
{
    public function __construct(protected array|string $needle)
    {
        //
    }

    public function match(QueryExecuted $executedQuery, Collection $explainResult): bool
    {
        return $explainResult
            ->filter(fn($result) => Str::contains($result->select_type, $this->needle, ignoreCase: true))
            ->isNotEmpty();
    }

    public function report(QueryExecuted $executedQuery, Collection $explainResult): void
    {
        throw new SelectTypeContainsDiagnosisException(
            $this->needle,
            $executedQuery,
            $explainResult
        );
    }
}
