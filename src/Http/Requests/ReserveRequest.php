<?php

namespace Reddot\TegetaReservation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'state_number' => 'required',
            'vehicle_type' => 'required',
            'user_type' => 'required',
            'branch' => 'required',
            'service_type' => 'required',
            'date' => 'required',
            'time' => 'required',
            'phone' => 'required',
        ];
    }
}
