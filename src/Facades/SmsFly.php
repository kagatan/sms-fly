<?php

namespace Kagatan\SmsFly\Facades;

use Illuminate\Support\Facades\Facade;
use Kagatan\SmsFly\SmsFlyClient;

class SmsFly extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return SmsFlyClient::class;
    }
}
