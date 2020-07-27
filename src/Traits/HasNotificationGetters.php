<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Piscibus\Notifly\Notifications\Icon;

trait HasNotificationGetters
{

    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }

    /**
     * @return int
     */
    public function getTrimmed(): int
    {
        return $this->trimmed_actors;
    }

    /**
     * @return array
     * @psalm-suppress UndefinedClass
     */
    public function getIcon(): array
    {
        $iconClass = config("notifly.icons.$this->verb");
        if (is_null($iconClass)) {
            return [];
        }
        /** @var Icon $icon */
        $icon = new $iconClass($this->jsonableActors, $this->object, $this->target);

        return $icon->toArray();
    }

    /**
     * @return Carbon|null
     */
    public function getSeenAt(): ?Carbon
    {
        return $this->seen_at;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return Carbon
     */
    public function getTime(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return Collection
     */
    public function getTrimmedActors(): Collection
    {
        return $this->jsonableActors;
    }
}
