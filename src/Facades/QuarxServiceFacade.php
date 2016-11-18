<?php

namespace Ayimdomnic\QuickSite\Facades;

use Illuminate\Support\Facades\Facade;

class quicksiteServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'quicksiteService';
    }
}
