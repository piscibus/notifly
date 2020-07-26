<?php


namespace Piscibus\Notifly\Tests\TestMocks\Models;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Traits\Morphable;

class Comment extends Model implements Transformable
{
    use Morphable;

    protected $table = 'object_examples';
}
