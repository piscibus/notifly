<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\ObjectAble;

class Like extends Model implements ObjectAble
{
    use \Piscibus\Notifly\Traits\ObjectAble;
    
    protected $table = 'object_examples';
}
