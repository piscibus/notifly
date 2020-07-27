<?php


namespace Piscibus\Notifly\Notifications;

use Illuminate\Support\Collection;
use Piscibus\Notifly\Contracts\MorphableInterface;

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
     * @var MorphableInterface
     */
    protected $object;

    /**
     * @var MorphableInterface
     */
    protected $target;

    /**
     * Icon constructor.
     * @param Collection $actors
     * @param MorphableInterface $object
     * @param MorphableInterface $target
     */
    public function __construct(Collection $actors, MorphableInterface $object, MorphableInterface $target)
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
