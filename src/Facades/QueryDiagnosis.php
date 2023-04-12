<?php

namespace SamAsEnd\QueryDiagnosis\Facades;

use Illuminate\Support\Facades\Facade;
use SamAsEnd\QueryDiagnosis\Strategies\QueryDiagnosisContract;

/**
 * @method static preventUnionSelectTypes(): void
 * @method static preventFullDatabaseScanQueries(): void
 * @method static preventFullIndexScanQueries(): void
 *
 * @method static customQueryDiagnosis(QueryDiagnosisContract $queryDiagnosis): void
 */
class QueryDiagnosis extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'querydiagnosis';
    }
}
