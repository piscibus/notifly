<?php

namespace Piscibus\Notifly\Tests\Commands;

use Piscibus\Notifly\Tests\TestCase;

class NotificationMakeCommandTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_creates_a_notification_class()
    {
        $parameters = ['name' => 'FooNotification', 'verb' => 'MyVerb'];
        $this->artisan('notifly:make:notification', $parameters)
            ->assertExitCode(0);
    }
}
