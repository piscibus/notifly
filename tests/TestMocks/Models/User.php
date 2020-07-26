<?php


namespace Piscibus\Notifly\Tests\TestMocks\Models;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\Transformable;
use Piscibus\Notifly\Traits\Morphable;
use Piscibus\Notifly\Traits\Notifiable;

class User extends Model implements Transformable
{
    use Notifiable, Morphable;
}
