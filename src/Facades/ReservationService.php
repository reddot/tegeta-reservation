<?php

namespace Reddot\TegetaReservation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Reddot\TegetaReservation\ReservationService
 */
class ReservationService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tegeta-reservation-service';
    }
}
