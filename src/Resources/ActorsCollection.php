<?php


namespace Piscibus\Notifly\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Models\NotificationActor;

/**
 * Class ActorsCollection
 * @package Piscibus\Notifly\Resources
 */
class ActorsCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        /** @var NotificationActor $actor */
        foreach ($this->collection as $actor) {
            /** @var Transformable $morphedActor */
            $morphedActor = $actor->actor;
            $data[] = $morphedActor->getTransformer();
        }

        return $data;
    }
}
