<?php

namespace Reddot\TegetaReservation\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Reddot\TegetaReservation\Facades\ReservationService;

class ReservationApiController extends Controller
{

    public function branches(Request $request): JsonResponse
    {
        $reservationInformation = ReservationService::reservationInformation();

        return response()->json([
            'branches' => $reservationInformation,
        ]);
    }

    public function services(Request $request): JsonResponse
    {
        $request->validate([
            'branch' => 'required',
        ]);

        $reservationInformation = ReservationService::reservationInformation();

        return response()->json([
            'services' => $reservationInformation[$request->branch],
        ]);
    }

    public function dates(Request $request): JsonResponse
    {
        $request->validate([
            'branch' => 'required',
            'service_type' => 'required',
            'year' => 'required',
            'month' => 'required',
        ]);

        $reservationInformationMonth = ReservationService::reservationInformationMonth($request->branch, $request->service_type, $request->year, $request->month);

        return response()->json([
            'available' => array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['available_datetimes']),
            'not_available' => array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['not_available_datetimes']),
        ]);
    }

    public function datesNMonth(Request $request): JsonResponse
    {
        $request->validate([
            'branch' => 'required',
            'service_type' => 'required',
            'year' => 'required',
            'month' => 'required',
            'n' => 'required'
        ]);
        $date = DateTime::createFromFormat('m-Y', $request->month . '-' . $request->year);
        $resultAvailable = [];
        $resultNotAvailable = [];

        for ($i = 0; $i < $request->n; $i++) {
            $year = $date->format('Y');
            $month = $date->format('m');
            $reservationInformationMonth = ReservationService::reservationInformationMonth($request->branch, $request->service_type, $year, $month);
            array_push($resultAvailable, array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['available_datetimes']));
            array_push($resultNotAvailable, array_map(fn ($d) => date_format(date_create($d), "m/d/Y"), $reservationInformationMonth[$request->branch]['not_available_datetimes']));

            date_add($date, date_interval_create_from_date_string('1 month'));
        }

        return response()->json([
            'available' => array_values(array_unique(Arr::flatten($resultAvailable))),
            'not_available' => array_values(array_unique(Arr::flatten($resultNotAvailable)))
        ]);
    }

    public function times(Request $request): JsonResponse
    {
        $request->validate([
            'branch' => 'required',
            'service_type' => 'required',
            'date' => 'required',
        ]);

        $reservationInformationMonth = ReservationService::reservationInformationFiltered($request->branch, $request->service_type, $request->date);

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

    public function reserve(Request $request): JsonResponse
    {
        $request->validate([
            'plate_number' => 'required',
            'car_type' => 'required',
            'user_type' => 'required',
            'branch' => 'required',
            'service' => 'required',
            'date' => 'required',
            'time' => 'required',
            'phone' => 'required',
        ]);

        $reserveResult = ReservationService::reserve(
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