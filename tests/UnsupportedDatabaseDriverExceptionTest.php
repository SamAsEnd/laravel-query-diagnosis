<?php

namespace SamAsEnd\QueryDiagnosis\Tests;

use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SamAsEnd\QueryDiagnosis\Exceptions\UnsupportedDatabaseDriverException;
use SamAsEnd\QueryDiagnosis\Facades\QueryDiagnosis;

class UnsupportedDatabaseDriverExceptionTest extends TestCase
{
    public function test_pgsql_driver_throw_exception()
    {
        $this->expectException(UnsupportedDatabaseDriverException::class);
        $this->expectExceptionMessage("Only support mysql driver for now. (pgsql) given.");

        QueryDiagnosis::preventFullDatabaseScanQueries();

        /** @var Connection $connection */
        $connection = DB::connection('pgsql');

        event(new QueryExecuted('SELECT * FROM authors', [], 0, $connection));
    }

    public function test_sqlite_driver_throw_exception()
    {
        $this->expectException(UnsupportedDatabaseDriverException::class);
        $this->expectExceptionMessage("Only support mysql driver for now. (sqlite) given.");

        QueryDiagnosis::preventFullDatabaseScanQueries();

        if (!File::exists(database_path('database.sqlite'))) {
            File::put(database_path('database.sqlite'), '');
        }

        /** @var Connection $connection */
        $connection = DB::connection('sqlite');

        event(new QueryExecuted('SELECT * FROM authors', [], 0, $connection));
    }

    public function test_sqlsrv_driver_throw_exception()
    {
        $this->expectException(UnsupportedDatabaseDriverException::class);
        $this->expectExceptionMessage("Only support mysql driver for now. (sqlsrv) given.");

        QueryDiagnosis::preventFullDatabaseScanQueries();

        /** @var Connection $connection */
        $connection = DB::connection('sqlsrv');

        event(new QueryExecuted('SELECT * FROM authors', [], 0, $connection));
    }
}
