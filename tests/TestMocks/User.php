<?php


namespace Piscibus\Notifly\Tests\TestMocks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Contracts\Transformer;
use Piscibus\Notifly\Traits\Morphable;

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
