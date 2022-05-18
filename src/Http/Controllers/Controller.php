<?php

namespace Ibrhaim13\Translate\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BasicController;

class Controller extends BasicController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}