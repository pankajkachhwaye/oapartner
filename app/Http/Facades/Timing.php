<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;

class Timing extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'timing';
    }

}