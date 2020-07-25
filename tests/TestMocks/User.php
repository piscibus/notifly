<?php


namespace Piscibus\Notifly\Tests\TestMocks;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Contracts\Transformer;
use Piscibus\Notifly\Traits\Morphable;
use Piscibus\Notifly\Traits\Notifiable;

class User extends Model implements Transformable
{
    use Notifiable, Morphable;

    /**
     * @inheritDoc
     */
    public function getTransformer(): Transformer
    {
        // TODO: Implement getTransformer() method.
    }
}
