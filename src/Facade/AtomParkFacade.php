<?php

namespace Ognistyi\AtomPark\Facade;

use Illuminate\Support\Facades\Facade;
use Ognistyi\AtomPark\AtomPark;

/**
 * Facade for the AtomPack SMS service
 *
 * @see AtomPark
 */
class AtomParkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AtomPark';
    }
}
