<?php

namespace Piscibus\Notifly\Tests;

use CreateExampleObjectTable;
use CreateExampleTargetTable;
use CreateNotiflyNotificationActorTable;
use CreateNotiflyNotificationTable;
use CreateNotiflyReadNotificationsTable;
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
            'database' => __DIR__ . '/sqlite.db',
            'prefix' => '',
        ]);

        include_once __DIR__ . '/../database/migrations/create_notifly_notification_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_notifly_read_notification_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_notifly_notification_actor_table.php.stub';

        (new CreateNotiflyNotificationTable())->up();
        (new CreateNotiflyReadNotificationsTable())->up();
        (new CreateNotiflyNotificationActorTable())->up();

        include_once __DIR__ . '/database/migrations/CreateUserTable.php';
        include_once __DIR__ . '/database/migrations/CreateExampleObjectTable.php';
        include_once __DIR__ . '/database/migrations/CreateExampleTargetTable.php';

        (new CreateUserTable())->up();
        (new CreateExampleObjectTable())->up();
        (new CreateExampleTargetTable())->up();
    }
}
