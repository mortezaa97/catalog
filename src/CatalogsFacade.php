<?php

namespace Mortezaa97\Catalogs;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mortezaa97\Catalogs\Skeleton\SkeletonClass
 */
class CatalogsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'catalogs';
    }
}
