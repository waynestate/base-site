<?php

namespace Styleguide\Http\Middleware;

use App\Http\Middleware\DataMiddleware as Middleware;

class DataMiddleware extends Middleware
{
    /** @var $prefix **/
    protected $prefix = 'Styleguide';
}
