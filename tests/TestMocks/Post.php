<?php


namespace Piscibus\Notifly\Tests\TestMocks;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Contracts\Transformer;
use Piscibus\Notifly\Traits\Morphable;

class Post extends Model implements Transformable
{
    use Morphable;

    protected $table = 'target_examples';
    
    /**
     * @inheritDoc
     */
    public function getTransformer(): Transformer
    {
        // TODO: Implement getTransformer() method.
    }
}
