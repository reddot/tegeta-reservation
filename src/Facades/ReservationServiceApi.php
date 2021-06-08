<?php

namespace Reddot\TegetaReservation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Reddot\TegetaReservation\ReservationServiceApi
 */
class ReservationServiceApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tegeta-reservation-service-api';
    }
}
