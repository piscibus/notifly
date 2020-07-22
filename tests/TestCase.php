<?php

namespace Piscibus\Notifly\Tests;

use CreateExampleObjectTable;
use CreateExampleTargetTable;
use CreateNotiflyTable;
use CreateUserTable;
use Orchestra\Testbench\TestCase as Orchestra;
use Piscibus\Notifly\NotiflyServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            NotiflyServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->migrations();
    }

    private function migrations(): void
    {
        $this->publishedMigrations();

        $this->testingMigrations();
    }

    private function publishedMigrations(): void
    {
        include_once __DIR__ . '/../database/migrations/create_notifly_table.php.stub';
        (new CreateNotiflyTable())->up();
    }

    private function testingMigrations(): void
    {
        include_once __DIR__ . '/database/migrations/CreateUserTable.php';
        include_once __DIR__ . '/database/migrations/CreateExampleObjectTable.php';
        include_once __DIR__ . '/database/migrations/CreateExampleTargetTable.php';

        (new CreateUserTable())->up();
        (new CreateExampleObjectTable())->up();
        (new CreateExampleTargetTable())->up();
    }
}
