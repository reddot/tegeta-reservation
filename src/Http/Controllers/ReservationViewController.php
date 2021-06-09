<?php

namespace Reddot\TegetaReservation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Reddot\TegetaReservation\Facades\ReservationService;
use Reddot\TegetaReservation\Facades\ReservationServiceApi;
use Reddot\TegetaReservation\Http\Middleware\ForceJsonResponse;
use Reddot\TegetaReservation\Http\Requests\DatesNMonthRequest;
use Reddot\TegetaReservation\Http\Requests\DatesRequest;
use Reddot\TegetaReservation\Http\Requests\ReserveRequest;
use Reddot\TegetaReservation\Http\Requests\ServicesRequest;
use Reddot\TegetaReservation\Http\Requests\TimesRequest;

class ReservationViewController extends Controller
{
    public function __construct()
    {
        $this->middleware(ForceJsonResponse::class);
    }

    public function branches(): JsonResponse
    {
        return response()->json([
            'view' => view('tegeta-reservation::branches', ['branches' => ReservationService::getBranches()])->render(),
        ]);
    }

    public function services(ServicesRequest $request): JsonResponse
    {
        return response()->json([
            'view' => view('tegeta-reservation::services', ['services' => ReservationService::getServicesFromRequest($request)])->render(),
        ]);
    }

    public function dates(DatesRequest $request): JsonResponse
    {
        return response()->json([
            'view' => view('tegeta-reservation::dates', ['datetimes' => ReservationService::getAvailableDatetimesFromRequest($request)])->render(),
        ]);
    }

    public function datesNMonth(DatesNMonthRequest $request): JsonResponse
    {
        return response()->json([
            'view' => view('tegeta-reservation::dates-n-month', ['datetimes' => ReservationService::getAvailableDatetimesForMultiMonthFromRequest($request)])->render(),
        ]);
    }

    public function times(TimesRequest $request): JsonResponse
    {
        return response()->json([
            'view' => view('tegeta-reservation::times', ['times' => ReservationService::getAvailableTimesFromRequest($request)])->render(),
        ]);
    }

    public function reserve(ReserveRequest $request): RedirectResponse
    {
        ReservationService::storeReservationFromRequest($request);

        return redirect()->back();
    }
}
