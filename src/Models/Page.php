<?php

namespace Ayimdomnic\QuickSite\Models;

use Ayimdomnic\QuickSite\Traits\Translatable;

class Page extends quicksiteModel
{
    use Translatable;

    public $table = 'pages';

    public $primaryKey = 'id';

    protected $guarded = [];

    public static $rules = [
        'title' => 'required',
        'url'   => 'required',
    ];

    protected $appends = [
        'translations',
    ];
}
