<?php

namespace SamAsEnd\QueryDiagnosis\Tests;

use SamAsEnd\QueryDiagnosis\Exceptions\JoinTypeDiagnosisException;
use SamAsEnd\QueryDiagnosis\Exceptions\SelectTypeContainsDiagnosisException;
use SamAsEnd\QueryDiagnosis\QueryDiagnosis;
use SamAsEnd\QueryDiagnosis\Tests\Models\Author;
use SamAsEnd\QueryDiagnosis\Tests\Models\Post;
use SamAsEnd\QueryDiagnosis\Tests\Models\Profile;

class QueryDiagnosisTest extends TestCase
{
    public function test_select_all_throws_an_exception()
    {
        $this->expectException(JoinTypeDiagnosisException::class);

        QueryDiagnosis::preventFullDatabaseScanQueries();

        Author::all();
    }

    public function test_union_queries_throw_exceptions()
    {
        $this->expectException(SelectTypeContainsDiagnosisException::class);

        QueryDiagnosis::preventUnionSelectTypes();

        Profile::query()->select('author_id')
            ->union(Post::query()->select('author_id'))
            ->get();
    }

    public function test_select_by_id_does_not_throws_an_exception()
    {
        QueryDiagnosis::preventUnionSelectTypes();
        QueryDiagnosis::preventFullDatabaseScanQueries();
        QueryDiagnosis::preventFullIndexScanQueries();

        Author::query()->find(1);

        $this->expectNotToPerformAssertions();
    }
}
