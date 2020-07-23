<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\MorphAble;

class TargetExample extends Model implements MorphAble
{
    use \Piscibus\Notifly\Traits\MorphAble;
}
