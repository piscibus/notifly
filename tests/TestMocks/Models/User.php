<?php


namespace Piscibus\Notifly\Tests\TestMocks\Models;

use Illuminate\Database\Eloquent\Model;
use Piscibus\Notifly\Contracts\TransformableInterface;
use Piscibus\Notifly\Traits\Notifiable;

class User extends Model implements TransformableInterface
{
    use Notifiable;
}
