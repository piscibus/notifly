<?php

namespace Piscibus\Notifly\Tests\Aggregates;

use Piscibus\Notifly\Aggregates\Aggregator;
use Piscibus\Notifly\Aggregates\Item;
use Piscibus\Notifly\Models\Notifly;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestModels\TargetExample;

/**
 * Class AggregatorTest
 * @package Piscibus\Notifly\Tests\Aggregators
 */
class AggregatorTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_ad_an_item()
    {
        $aggregator = new Aggregator();
        $notifly = factory(Notifly::class)->create();
        $item = Item::fromNotifly($notifly);
        $aggregator->add($item);
        $this->assertEquals(1, $aggregator->getCount());
    }

    /**
     * @test
     */
    public function test_it_aggregates_the_same_notifications()
    {
        $target = factory(TargetExample::class)->create();
        $attributes = ['verb' => 'foo'];
        $notifications = factory(Notifly::class, 10)
            ->create($attributes)->each(function (Notifly $notifly) use ($target) {
                $notifly->target()->associate($target);
            });

        $aggregator = new Aggregator();
        foreach ($notifications as $notification) {
            $item = Item::fromNotifly($notification);
            $aggregator->add($item);
        }
        $this->assertEquals(1, $aggregator->getCount());
    }
}
