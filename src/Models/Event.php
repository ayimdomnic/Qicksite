<?php

namespace Ayimdomnic\QuickSite\Models;

use Ayimdomnic\QuickSite\Traits\Translatable;

class Event extends QuickSiteModel
{
    use Translatable;

    public $table = 'events';

    public $primaryKey = 'id';

    protected $guarded = [];

    public static $rules = [
        'title' => 'required',
    ];

    protected $appends = [
        'translations',
    ];
}
