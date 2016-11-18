<?php

namespace Ayimdomnic\QuickSite\Models;

use Ayimdomnic\QuickSite\Traits\Translatable;

class Blog extends quicksiteModel
{
    use Translatable;

    public $table = 'blogs';

    public $primaryKey = 'id';

    protected $guarded = [];

    public static $rules = [
        'title' => 'required|string',
        'url'   => 'required|string',
    ];

    protected $appends = [
        'translations',
    ];
}
