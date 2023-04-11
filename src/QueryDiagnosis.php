<?php

namespace SamAsEnd\QueryDiagnosis;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SamAsEnd\QueryDiagnosis\Enums\JoinType;
use SamAsEnd\QueryDiagnosis\Strategies\JoinTypeQueryDiagnosis;
use SamAsEnd\QueryDiagnosis\Strategies\QueryDiagnosisContract;
use SamAsEnd\QueryDiagnosis\Strategies\SelectTypeContainsQueryDiagnosis;

class QueryDiagnosis
{
    private const SELECT = 'select ';

    private const EXPLAIN = 'explain ';

    private const UNION = 'UNION';

    protected static ?Collection $queryDiagnoses = null;

    protected static ?Collection $queriesCache = null;

    protected static bool $booted = false;

    public static function preventUnionSelectTypes(): void
    {
        static::customQueryDiagnosis(new SelectTypeContainsQueryDiagnosis(self::UNION));
    }

    public static function preventFullDatabaseScanQueries(): void
    {
        static::customQueryDiagnosis(new JoinTypeQueryDiagnosis(JoinType::ALL));
    }

    public static function preventFullIndexScanQueries(): void
    {
        static::customQueryDiagnosis(new JoinTypeQueryDiagnosis(JoinType::INDEX));
    }

    public static function customQueryDiagnosis(QueryDiagnosisContract $queryDiagnosis): void
    {
        static::boot();

        static::$queryDiagnoses->push($queryDiagnosis);
    }

    protected static function boot(): void
    {
        if (!static::$booted) {
            static::$booted = true;

            if (static::$queriesCache === null) {
                static::$queriesCache = Collection::make();
            }

            if (static::$queryDiagnoses === null) {
                static::$queryDiagnoses = Collection::make();
            }

            DB::listen(function (QueryExecuted $executedQuery) {
                $query = Str::of($executedQuery->sql)
                    ->lower()
                    ->trim('()') // laravel sometime group the queries as (select...)
                    ->trim()
                    ->value();

                if (static::shouldBeDiagnosed($query)) {
                    static::$queriesCache->push($query);
                    static::diagnoseQuery($executedQuery);
                }
            });
        }
    }

    protected static function shouldBeDiagnosed(string $query): bool
    {
        return Str::startsWith($query, static::SELECT)
            && static::$queriesCache->doesntContain($query);
    }

    protected static function diagnoseQuery(QueryExecuted $queryExecuted): void
    {
        $explainResults = collect($queryExecuted->connection->select(
            self::EXPLAIN.$queryExecuted->sql,
            $queryExecuted->bindings
        ));

        /** @var QueryDiagnosisContract $queryDiagnosis */
        foreach (static::$queryDiagnoses as $queryDiagnosis) {
            if ($queryDiagnosis->match($queryExecuted, $explainResults)) {
                $queryDiagnosis->report($queryExecuted, $explainResults);
            }
        }
    }

    public static function resetForTesting(): void
    {
        static::$booted = false;
        static::$queryDiagnoses = null;
        static::$queriesCache = null;
    }
}
