<?php


namespace Piscibus\Notifly\Aggregates;

use Illuminate\Support\Collection;
use Piscibus\Notifly\Contracts\MorphAble;
use Piscibus\Notifly\Models\Notifly;

class Item
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $verb;

    /**
     * @var Collection
     */
    private $actors;

    /**
     * @var MorphAble
     */
    private $object;

    /**
     * @var MorphAble
     */
    private $target;

    /**
     * Item constructor.
     * @param string $id
     * @param string $verb
     * @param array|MorphAble[] $actors
     * @param MorphAble $object
     * @param MorphAble $target
     */
    public function __construct(string $id, string $verb, array $actors, MorphAble $object, MorphAble $target)
    {
        $this->id = $id;
        $this->verb = $verb;
        $this->initActors($actors);
        $this->object = $object;
        $this->target = $target;
    }

    /**
     * @param Notifly $notifly
     * @return static
     */
    public static function fromNotifly(Notifly $notifly): self
    {
        return new self(
            $notifly->getId(),
            $notifly->getVerb(),
            [$notifly->getActor()],
            $notifly->getObject(),
            $notifly->getTarget()
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }

    /**
     * @return Collection
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    /**
     * @return MorphAble
     */
    public function getObject(): MorphAble
    {
        return $this->object;
    }

    /**
     * @return MorphAble
     */
    public function getTarget(): MorphAble
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getGroupKey(): string
    {
        return sprintf("%s:%s:%s", $this->verb, $this->target->getType(), $this->target->getId());
    }

    /**
     * @param array $actors
     */
    private function initActors(array $actors): void
    {
        $this->actors = new Collection();
        foreach ($actors as $actor) {
            $this->addActor($actor);
        }
    }

    /**
     * @param $actor
     */
    public function addActor(MorphAble $actor): void
    {
        $id = spl_object_hash($actor);
        $this->actors->put($id, $actor);
    }
}
