<?php

namespace Reddot\TegetaReservation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Reddot\TegetaReservation\Facades\ReservationService;

class ReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'state_number' => ['required'],
            'vehicle_type' => ['required', 'in:' . implode(",", ReservationService::getVehicleTypeInputNames())],
            'user_type' => ['required', 'in:' . implode(",", ReservationService::getUserTypeInputNames())],
            'company_id' => ['required_if:user_type,company'],
            'branch' => ['required'],
            'service_type' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
            'phone' => ['required'],
        ];
    }
}
