<?php

namespace Dvomaks\PromuaApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dvomaks\PromuaApi\PromuaApi
 */
class PromuaApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Dvomaks\PromuaApi\PromuaApi::class;
    }
}
