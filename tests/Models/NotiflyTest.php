<?php

namespace Piscibus\Notifly\Tests\Models;

use Piscibus\Notifly\Models\Notifly;
use Piscibus\Notifly\Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class NotiflyTest
 * @package Piscibus\Notifly\Tests\Models
 */
class NotiflyTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_has_a_uuid_primary_key()
    {
        $attributes = ['verb' => 'foo'];
        $notification = Notifly::create($attributes);
        $uuid = Uuid::fromString($notification->getId());
        $this->assertInstanceOf(UuidInterface::class, $uuid);
    }
}
