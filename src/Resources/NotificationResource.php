<?php


namespace Piscibus\Notifly\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Piscibus\Notifly\Models\Notification;

/**
 * Class NotificationResource
 * @package Piscibus\Notifly\Resources
 */
class NotificationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Notification $notification */
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
