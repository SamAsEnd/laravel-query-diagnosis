<?php

namespace SamAsEnd\QueryDiagnosis;

use Illuminate\Support\ServiceProvider;

class QueryDiagnosisServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('querydiagnosis', QueryDiagnosisImpl::class);
    }

    public function provides(): array
    {
        return ['querydiagnosis', QueryDiagnosisImpl::class];
    }
}
