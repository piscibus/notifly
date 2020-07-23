<?php


namespace Piscibus\Notifly\Aggregates;

use Illuminate\Support\Collection;

/**
 * Class Aggregator
 * @package Piscibus\Notifly\Aggregators
 */
class Aggregator
{
    /** @var Collection */
    private $collection;

    /**
     * Aggregator constructor.
     */
    public function __construct()
    {
        $this->collection = new Collection();
    }

    /**
     * @param Item $item
     */
    public function add(Item $item): void
    {
        $key = $item->getGroupKey();
        if ($this->collection->has($key)) {
            /** @var Item $parentItem */
            $parentItem = $this->collection->get($key);
            foreach ($item->getActors() as $actor) {
                $parentItem->addActor($actor);
            }

            return;
        }
        $this->collection->put($key, $item);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->collection->count();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->collection->toArray();
    }
}
