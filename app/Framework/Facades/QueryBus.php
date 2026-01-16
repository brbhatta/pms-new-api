<?php

namespace App\Framework\Facades;

use Illuminate\Support\Facades\Facade;

class QueryBus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'query.bus';
    }
}
