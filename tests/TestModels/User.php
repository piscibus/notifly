<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\ActorAble as ActorAbleContract;
use Piscibus\Notifly\Contracts\NotiflyAble as NotiflyAbleContract;
use Piscibus\Notifly\Traits\ActorAble;
use Piscibus\Notifly\Traits\NotiflyAble;

class User extends Model implements NotiflyAbleContract, ActorAbleContract
{
    use NotiflyAble, ActorAble;
}
