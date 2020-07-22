<?php


namespace Piscibus\Notifly\Tests\Channels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\TargetAble as TargetAbleContract;
use Piscibus\Notifly\Traits\TargetAble;

class TargetExample extends Model implements TargetAbleContract
{
    use TargetAble;
}
