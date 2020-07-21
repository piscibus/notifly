<?php

namespace Piscibus\Notifly;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Piscibus\Notifly\Notifly
 */
class NotiflyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'notifly';
    }
}
