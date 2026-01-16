<?php

namespace App\Framework\Facades;

use Illuminate\Support\Facades\Facade;

class CommandBus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'command.bus';
    }
}
