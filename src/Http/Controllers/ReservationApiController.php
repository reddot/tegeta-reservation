<?php

namespace Reddot\TegetaReservation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Reddot\TegetaReservation\Facades\ReservationService;
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

    public function branches(): JsonResponse
    {
        return response()->json([
            'branches' => ReservationService::getBranches(),
        ]);
    }

    public function services(ServicesRequest $request): JsonResponse
    {
        return response()->json([
            'services' => ReservationService::getServicesFromRequest($request),
        ]);
    }

    public function dates(DatesRequest $request): JsonResponse
    {
        $datetitmes = ReservationService::getAvailableDatetimesFromRequest($request);

        return response()->json([
            'available' => $datetitmes['available'],
            'not_available' => $datetitmes['not_available'],
        ]);
    }

    public function datesNMonth(DatesNMonthRequest $request): JsonResponse
    {
        $datetitmes = ReservationService::getAvailableDatetimesForMultiMonthFromRequest($request);

        return response()->json([
            'available' => $datetitmes['available'],
            'not_available' => $datetitmes['not_available'],
        ]);
    }

    public function times(TimesRequest $request): JsonResponse
    {
        $times = ReservationService::getAvailableTimesFromRequest($request);

        return response()->json([
            'times' => $times,
        ]);
    }

    public function reserve(ReserveRequest $request): JsonResponse
    {
        $reserveResult = ReservationService::storeReservationFromRequest($request);

        return response()->json($reserveResult);
    }
}
