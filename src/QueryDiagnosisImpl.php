<?php

namespace SamAsEnd\QueryDiagnosis;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SamAsEnd\QueryDiagnosis\Enums\JoinType;
use SamAsEnd\QueryDiagnosis\Exceptions\UnsupportedDatabaseDriverException;
use SamAsEnd\QueryDiagnosis\Strategies\JoinTypeQueryDiagnosis;
use SamAsEnd\QueryDiagnosis\Strategies\QueryDiagnosisContract;
use SamAsEnd\QueryDiagnosis\Strategies\SelectTypeContainsQueryDiagnosis;

class QueryDiagnosisImpl
{
    private const SELECT = 'select ';

    private const EXPLAIN = 'explain ';

    private const UNION = 'UNION';

    protected readonly Collection $queryDiagnoses;

    protected readonly Collection $queriesCache;

    protected bool $booted = false;

    public function __construct()
    {
        $this->queryDiagnoses = Collection::make();
        $this->queriesCache = Collection::make();

        $this->booted = false;
    }

    public function preventUnionSelectTypes(): void
    {
        $this->customQueryDiagnosis(new SelectTypeContainsQueryDiagnosis(self::UNION));
    }

    public function preventFullDatabaseScanQueries(): void
    {
        $this->customQueryDiagnosis(new JoinTypeQueryDiagnosis(JoinType::ALL));
    }

    public function preventFullIndexScanQueries(): void
    {
        $this->customQueryDiagnosis(new JoinTypeQueryDiagnosis(JoinType::INDEX));
    }

    public function customQueryDiagnosis(QueryDiagnosisContract $queryDiagnosis): void
    {
        $this->boot();

        $this->queryDiagnoses->push($queryDiagnosis);
    }

    protected function boot(): void
    {
        if (!$this->booted) {
            $this->booted = true;

            DB::listen(function (QueryExecuted $executedQuery) {
                $query = Str::of($executedQuery->sql)
                    ->lower()
                    ->trim('()') // laravel sometime group the queries as (select...)
                    ->trim()
                    ->value();

                if (static::shouldBeDiagnosed($query)) {
                    $this->queriesCache->push($query);
                    static::diagnoseQuery($executedQuery);
                }
            });
        }
    }

    protected function shouldBeDiagnosed(string $query): bool
    {
        return Str::startsWith($query, static::SELECT)
            && $this->queriesCache->doesntContain($query);
    }

    protected function diagnoseQuery(QueryExecuted $queryExecuted): void
    {
        if ('mysql' !== ($driver = $queryExecuted->connection->getDriverName())) {
            throw new UnsupportedDatabaseDriverException($driver);
        }

        $explainResults = collect($queryExecuted->connection->select(
            self::EXPLAIN.$queryExecuted->sql,
            $queryExecuted->bindings
        ));

        /** @var QueryDiagnosisContract $queryDiagnosis */
        foreach ($this->queryDiagnoses as $queryDiagnosis) {
            if ($queryDiagnosis->match($queryExecuted, $explainResults)) {
                $queryDiagnosis->report($queryExecuted, $explainResults);
            }
        }
    }
}
