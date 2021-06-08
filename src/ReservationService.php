<?php

namespace Reddot\TegetaReservation;

use DateTime;
use Illuminate\Support\Arr;
use Reddot\TegetaReservation\Facades\ReservationServiceApi;
use Reddot\TegetaReservation\Http\Requests\DatesNMonthRequest;
use Reddot\TegetaReservation\Http\Requests\DatesRequest;
use Reddot\TegetaReservation\Http\Requests\ReserveRequest;
use Reddot\TegetaReservation\Http\Requests\ServicesRequest;
use Reddot\TegetaReservation\Http\Requests\TimesRequest;

class ReservationService
{
    public function getServices(string $branch)
    {
        $reservationInformation = ReservationServiceApi::reservationInformation();

        if (! array_key_exists($branch, $reservationInformation)) {
            abort(404);
        }

        return $reservationInformation[$branch];
    }

    public function getAvailableDatetimes($branch, $service_type, $year, $month)
    {
        $reservationInformationMonth = ReservationServiceApi::reservationInformationMonth($branch, $service_type, $year, $month);

        if (! array_key_exists($branch, $reservationInformationMonth)) {
            abort(404);
        }

        return [
            'available' => array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$branch]['available_datetimes']),
            'not_available' => array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$branch]['not_available_datetimes']),
        ];
    }

    public function getAvailableDatetimesForMultiMonth($branch, $service_type, $year, $month, $n)
    {
        $date = DateTime::createFromFormat('m-Y', $month . '-' . $year);
        $resultAvailable = [];
        $resultNotAvailable = [];

        for ($i = 0; $i < $n; $i++) {
            $year = $date->format('Y');
            $month = $date->format('m');
            $datetitmes = $this->getAvailableDatetimes($branch, $service_type, $year, $month);

            array_push($resultAvailable, $datetitmes['available']);
            array_push($resultNotAvailable, $datetitmes['not_available']);

            date_add($date, date_interval_create_from_date_string('1 month'));
        }

        return [
            'available' => array_values(array_unique(Arr::flatten($resultAvailable))),
            'not_available' => array_values(array_unique(Arr::flatten($resultNotAvailable))),
        ];
    }

    public function getAvailableTimes($branch, $service_type, $date)
    {
        $reservationInformationMonth = ReservationServiceApi::reservationInformationFiltered($branch, $service_type, $date);

        if (
            ! array_key_exists($branch, $reservationInformationMonth) ||
            ! array_key_exists($service_type, $reservationInformationMonth[$branch])
        ) {
            abort(404);
        }

        $times = $reservationInformationMonth[$branch][$service_type];

        $times['available'] = [];
        foreach ($times['reservation_times'] as $reservationTime) {
            $available = true;

            foreach ($times['not_available_datetimes'] as $notAvailableTime) {
                if (str_contains($notAvailableTime, $reservationTime)) {
                    $available = false;

                    break;
                }
            }

            if ($available) {
                array_push($times['available'], $reservationTime);
            }
        }

        return $times;
    }

    public function storeReservation($plate_number, $car_type, $user_type, $IDNumber, $company_id, $branch, $service, $date, $time, $phone)
    {
        return ReservationServiceApi::reserve($plate_number, $car_type, $user_type, $IDNumber, $company_id, $branch, $service, $date, $time, $phone);
    }

    /** Getting resources from request */
    public function getServicesFromRequest(ServicesRequest $r)
    {
        return $this->getServices($r->branch);
    }

    public function getAvailableDatetimesFromRequest(DatesRequest $r)
    {
        return $this->getAvailableDatetimes($r->branch, $r->service_type, $r->year, $r->month);
    }

    public function getAvailableDatetimesForMultiMonthFromRequest(DatesNMonthRequest $r)
    {
        return $this->getAvailableDatetimesForMultiMonth($r->branch, $r->service_type, $r->year, $r->month, $r->n);
    }

    public function getAvailableTimesFromRequest(TimesRequest $r)
    {
        return $this->getAvailableTimes($r->branch, $r->service_type, $r->date);
    }

    public function storeReservationFromRequest(ReserveRequest $r)
    {
        return $this->storeReservation($r->plate_number, $r->car_type, $r->user_type, $r->IDNumber, $r->company_id, $r->branch, $r->service, $r->date, $r->time, $r->phone);
    }
}
