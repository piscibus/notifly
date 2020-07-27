<?php


namespace Piscibus\Notifly\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class JsonNotifications
 * @package Piscibus\Notifly\Resources
 */
class JsonNotifications extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $notification = $this->resource;

        return [
            'id' => $notification->getId(),
            'verb' => $notification->getVerb(),
            'time' => $notification->getTime(),
            'object' => $notification->getObject()->getTransformer(),
            'target' => $notification->getTarget()->getTransformer(),
            'icon' => $notification->getIcon(),
            'actors' => [
                'data' => new ActorsCollection($notification->getTrimmedActors()),
                'trimmed' => $notification->getTrimmed(),
            ],
        ];
    }
}
