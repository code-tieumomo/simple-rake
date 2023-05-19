<?php

namespace Quanph\SimpleRake;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Quanph\SimpleRake\Skeleton\SkeletonClass
 */
class SimpleRakeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'simple-rake';
    }
}
