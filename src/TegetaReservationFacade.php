<?php

namespace Reddot\TegetaReservation;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Reddot\TegetaReservation\TegetaReservation
 */
class TegetaReservationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tegeta-reservation';
    }
}
