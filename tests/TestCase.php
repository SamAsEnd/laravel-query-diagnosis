<?php

namespace SamAsEnd\QueryDiagnosis\Tests;

use Illuminate\Database\Schema\Blueprint;
use SamAsEnd\QueryDiagnosis\Facades\QueryDiagnosis;
use SamAsEnd\QueryDiagnosis\QueryDiagnosisServiceProvider;
use SamAsEnd\QueryDiagnosis\Tests\Seeder\TestSeeder;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected static $setUpRun = false;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->withFactories(__DIR__.'/Factories/');

        $this->seed(TestSeeder::class);
    }

    protected function getPackageProviders($app): array
    {
        return [QueryDiagnosisServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'QueryDiagnosis' => QueryDiagnosis::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'mysql',
            'database' => 'querydiagnosis',
        ] + $app['config']->get('database.connections.mysql'));

        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpDatabase(): void
    {
        $this->app['db']->connection()->getSchemaBuilder()->dropAllTables();

        $this->app['db']->connection()->getSchemaBuilder()->create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->nullable();
            $table->string('email')->unique();
            $table->text('bio')->fulltext();
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->date('birthday');
            $table->string('city');
            $table->string('state');
            $table->string('website');
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->morphs('commentable');
        });
    }
}
