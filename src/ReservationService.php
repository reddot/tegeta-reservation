<?php

namespace Reddot\TegetaReservation;

use DateTime;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Reddot\TegetaReservation\Facades\ReservationServiceApi;

use Reddot\TegetaReservation\Http\Controllers\ReservationApiController;
use Reddot\TegetaReservation\Http\Controllers\ReservationViewController;
use Reddot\TegetaReservation\Http\Requests\DatesNMonthRequest;
use Reddot\TegetaReservation\Http\Requests\DatesRequest;
use Reddot\TegetaReservation\Http\Requests\ReserveRequest;
use Reddot\TegetaReservation\Http\Requests\ServicesRequest;
use Reddot\TegetaReservation\Http\Requests\TimesRequest;

class ReservationService
{
    /** Routes */
    public function routes()
    {
        return
            Route::name('reservation.')->prefix('reservation')->group(function () {
                Route::name('api.')->prefix('api')->group(function () {
                    Route::get('/branches', [ReservationApiController::class, 'branches'])->name('branches');
                    Route::get('/services', [ReservationApiController::class, 'services'])->name('services');
                    Route::get('/dates', [ReservationApiController::class, 'dates'])->name('dates');
                    Route::get('/dates-n-month', [ReservationApiController::class, 'datesNMonth'])->name('dates-n-month');
                    Route::get('/times', [ReservationApiController::class, 'times'])->name('times');
                    Route::post('/reserve', [ReservationApiController::class, 'reserve'])->name('reserve');
                });
                Route::name('view.')->prefix('view')->group(function () {
                    Route::get('/branches', [ReservationViewController::class, 'branches'])->name('branches');
                    Route::get('/services', [ReservationViewController::class, 'services'])->name('services');
                    Route::get('/dates', [ReservationViewController::class, 'dates'])->name('dates');
                    Route::get('/dates-n-month', [ReservationViewController::class, 'datesNMonth'])->name('dates-n-month');
                    Route::get('/times', [ReservationViewController::class, 'times'])->name('times');
                    Route::post('/reserve', [ReservationViewController::class, 'reserve'])->name('reserve');
                });
            });
    }

    /** Configs */
    public function getApiRoute()
    {
        return config('tegeta-reservation.url');
    }

    public function getVehicleTypes()
    {
        return config('tegeta-reservation.vehicle_types') ?? [];
    }

    public function getUserTypes()
    {
        return config('tegeta-reservation.user_types') ?? [];
    }

    /** Gettind resources from arguments */
    public function getBranches()
    {
        $branches = array_keys(ReservationServiceApi::reservationInformation());

        return $branches;
    }

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
            'available' => array_map(fn ($d) => date_format(date_create($d), "Y-m-d"), $reservationInformationMonth[$branch]['available_datetimes']),
            'not_available' => array_map(fn ($d) => date_format(date_create($d), "Y-m-d"), $reservationInformationMonth[$branch]['not_available_datetimes']),
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

    public function storeReservation($stateNumber, $vehicleType, $userType, $IDNumber, $companyID, $branch, $service, $date, $time, $phone)
    {
        return ReservationServiceApi::reserve($stateNumber, $vehicleType, $userType, $IDNumber, $companyID, $branch, $service, $date, $time, $phone);
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
        return $this->storeReservation($r->state_number, $r->vehicle_type, $r->user_type, $r->IDNumber, $r->company_id, $r->branch, $r->service, $r->date, $r->time, $r->phone);
    }
}
