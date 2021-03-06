<?php


namespace Piscibus\Notifly\Tests\TestMocks\Models;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\TransformableInterface;
use Piscibus\Notifly\Traits\Notifly;

class Comment extends Model implements TransformableInterface
{
    use Notifly;

    protected $table = 'object_examples';
}
