<?php


namespace Piscibus\Notifly\Tests\TestMocks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Traits\Morphable;
use Piscibus\Notifly\Traits\Notifiable;

class User extends Model implements Transformable
{
    use Notifiable, Morphable;

    /**
     * @inheritDoc
     */
    public function getTransformer(): JsonResource
    {
        // TODO: Implement getTransformer() method.
    }
}
