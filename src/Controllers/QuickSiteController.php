<?php

namespace Ayimdomnic\Quicksite\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class QuickSiteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
