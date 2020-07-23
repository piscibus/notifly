<?php

namespace Piscibus\Notifly\Tests\Aggregates;

use Piscibus\Notifly\Aggregates\Item;
use Piscibus\Notifly\Models\Notifly;
use Piscibus\Notifly\Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_created_from_notifly_model()
    {
        $notifly = factory(Notifly::class)->create();
        $item = Item::fromNotifly($notifly);
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($notifly->id, $item->getId());
    }
}
