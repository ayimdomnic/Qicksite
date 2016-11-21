<?php

namespace Ayimdomnic\QuickSite\Facades;

use Illuminate\Support\Facades\Facade;

class QuckSiteServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QuickSiteService';
    }
}
