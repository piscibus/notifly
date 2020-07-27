<?php

namespace Piscibus\Notifly\Tests\Commands;

use Piscibus\Notifly\Tests\TestCase;

/**
 * Class IconMakeCommandTest
 * @package Piscibus\Notifly\Tests\Commands
 */
class IconMakeCommandTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_creates_a_notification_icon_class()
    {
        $parameters = ['name' => 'VerbIcon'];
        $this->artisan('notifly:make:icon', $parameters)
            ->assertExitCode(0);
    }
}
