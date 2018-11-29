<?php

namespace ErpConnect\Facades;


use Illuminate\Support\Facades\Facade;

class ErpConnect extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'erpconnect';
    }

}