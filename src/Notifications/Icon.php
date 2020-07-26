<?php


namespace Piscibus\Notifly\Notifications;

use Illuminate\Support\Collection;
use Piscibus\Notifly\Contracts\Morphable;

/**
 * Class Icon
 * @package Piscibus\Notifly\Notifications
 */
abstract class Icon
{
    /**
     * @var Collection
     */
    protected $actors;

    /**
     * @var Morphable
     */
    protected $object;

    /**
     * @var Morphable
     */
    protected $target;

    /**
     * Icon constructor.
     * @param Collection $actors
     * @param Morphable $object
     * @param Morphable $target
     */
    public function __construct(Collection $actors, Morphable $object, Morphable $target)
    {
        $this->actors = $actors;
        $this->object = $object;
        $this->target = $target;
    }

    /**
     * @return array
     */
    abstract public function toArray();
}
