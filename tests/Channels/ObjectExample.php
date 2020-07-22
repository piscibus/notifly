<?php


namespace Piscibus\Notifly\Tests\Channels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\ObjectAble as ObjectAbleContract;
use Piscibus\Notifly\Traits\ObjectAble;

class ObjectExample extends Model implements ObjectAbleContract
{
    use ObjectAble;
}
