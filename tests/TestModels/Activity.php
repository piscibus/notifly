<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\TargetAble;

class Activity extends Model implements TargetAble
{
    use \Piscibus\Notifly\Traits\TargetAble;
    
    protected $table = 'target_examples';
}
