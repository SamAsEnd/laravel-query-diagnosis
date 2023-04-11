<?php

namespace SamAsEnd\QueryDiagnosis\Tests;

use Illuminate\Database\Schema\Blueprint;
use SamAsEnd\QueryDiagnosis\QueryDiagnosis;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected static $setUpRun = false;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        QueryDiagnosis::resetForTesting();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql');

        $app['config']->set('database.connections.mysql', [
                'database' => 'querydiagnosis',
            ] + $app['config']->get('database.connections.mysql'));

        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpDatabase()
    {
        $this->app['db']->connection()->getSchemaBuilder()->dropAllTables();

        $this->app['db']->connection()->getSchemaBuilder()->create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('bio');
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
            $table->string('body');
            $table->morphs('commentable');
        });
    }
}
