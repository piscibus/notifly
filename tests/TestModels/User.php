<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\MorphAble as MorphAbleContract;
use Piscibus\Notifly\Traits\MorphAble;
use Piscibus\Notifly\Traits\NotiflyAble;

/**
 * Class User
 * @package Piscibus\Notifly\Tests\TestModels
 */
class User extends Model implements MorphAbleContract
{
    use MorphAble, NotiflyAble;
}
