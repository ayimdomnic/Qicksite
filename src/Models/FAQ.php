<?php

namespace Ayimdomnic\QuickSite\Models;

use Ayimdomnic\QuickSite\Traits\Translatable;

class FAQ extends QuickSiteModel
{
    use Translatable;

    public $table = 'faqs';

    public $primaryKey = 'id';

    protected $guarded = [];

    public static $rules = [
        'question' => 'required',
    ];

    protected $appends = [
        'translations',
    ];

    // protected $trends = [
    // 'getallheaders(oid)'
    // ];
}
