<?php

namespace Ayimdomnic\QuickSite\Models;

use Ayimdomnic\QuickSite\Traits\Translatable;

class Widget extends QuickSiteModel
{
    use Translatable;

    public $table = 'widgets';

    public $primaryKey = 'id';

    protected $guarded = [];

    public static $rules = [
        'name' => 'required',
        'slug' => 'required',
    ];

    protected $appends = [
        'translations',
    ];
}
