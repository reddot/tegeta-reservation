<?php

namespace Reddot\TegetaReservation\Http\Controllers;

use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Reddot\TegetaReservation\Facades\ReservationServiceApi;
use Reddot\TegetaReservation\Http\Middleware\ForceJsonResponse;
use Reddot\TegetaReservation\Http\Requests\DatesNMonthRequest;
use Reddot\TegetaReservation\Http\Requests\DatesRequest;
use Reddot\TegetaReservation\Http\Requests\ReserveRequest;
use Reddot\TegetaReservation\Http\Requests\ServicesRequest;
use Reddot\TegetaReservation\Http\Requests\TimesRequest;

class ReservationApiController extends Controller
{
    public function __construct()
    {
        $this->middleware(ForceJsonResponse::class);
    }

    public function branches(Request $request): JsonResponse
    {
        $reservationInformation = ReservationServiceApi::reservationInformation();

        return response()->json([
            'branches' => $reservationInformation,
        ]);
    }

    public function services(ServicesRequest $request): JsonResponse
    {
        $reservationInformation = ReservationServiceApi::reservationInformation();

        if (! array_key_exists($request->branch, $reservationInformation)) {
            abort(404);
        }

        return response()->json([
            'services' => $reservationInformation[$request->branch],
        ]);
    }

    public function dates(DatesRequest $request): JsonResponse
    {
        $reservationInformationMonth = ReservationServiceApi::reservationInformationMonth($request->branch, $request->service_type, $request->year, $request->month);

        if (! array_key_exists($request->branch, $reservationInformationMonth)) {
            abort(404);
        }

        return response()->json([
            'available' => array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['available_datetimes']),
            'not_available' => array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['not_available_datetimes']),
        ]);
    }

    public function datesNMonth(DatesNMonthRequest $request): JsonResponse
    {
        $date = DateTime::createFromFormat('m-Y', $request->month . '-' . $request->year);
        $resultAvailable = [];
        $resultNotAvailable = [];

        for ($i = 0; $i < $request->n; $i++) {
            $year = $date->format('Y');
            $month = $date->format('m');
            $reservationInformationMonth = ReservationServiceApi::reservationInformationMonth($request->branch, $request->service_type, $year, $month);

            if (! array_key_exists($request->branch, $reservationInformationMonth)) {
                abort(404);
            }

            array_push($resultAvailable, array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['available_datetimes']));
            array_push($resultNotAvailable, array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['not_available_datetimes']));

            date_add($date, date_interval_create_from_date_string('1 month'));
        }

        return response()->json([
            'available' => array_values(array_unique(Arr::flatten($resultAvailable))),
            'not_available' => array_values(array_unique(Arr::flatten($resultNotAvailable))),
        ]);
    }

    public function times(TimesRequest $request): JsonResponse
    {
        $reservationInformationMonth = ReservationServiceApi::reservationInformationFiltered($request->branch, $request->service_type, $request->date);

        if (
            ! array_key_exists($request->branch, $reservationInformationMonth) ||
            ! array_key_exists($request->service_type, $reservationInformationMonth[$request->branch])
        ) {
            abort(404);
        }

        $times = $reservationInformationMonth[$request->branch][$request->service_type];

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

        return response()->json([
            'times' => $times,
        ]);
    }

    public function reserve(ReserveRequest $request): JsonResponse
    {
        $reserveResult = ReservationServiceApi::reserve(
            $request->plate_number,
            $request->car_type,
            $request->user_type,
            $request->IDNumber,
            $request->company_id,
            $request->branch,
            $request->service,
            $request->date,
            $request->time,
            $request->phone
        );

        return response()->json($reserveResult);
    }
}
