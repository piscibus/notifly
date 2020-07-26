<?php


namespace Piscibus\Notifly\Tests\TestMocks\Models;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Traits\Morphable;

class Post extends Model implements Transformable
{
    use Morphable;

    protected $table = 'target_examples';
}
