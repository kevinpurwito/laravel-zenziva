<?php

namespace Kevinpurwito\LaravelZenziva;

use Illuminate\Support\Facades\Facade;

class ZenzivaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Zenziva';
    }
}
