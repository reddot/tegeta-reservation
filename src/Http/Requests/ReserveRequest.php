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
            'plate_number' => 'required',
            'car_type' => 'required',
            'user_type' => 'required',
            'branch' => 'required',
            'service' => 'required',
            'date' => 'required',
            'time' => 'required',
            'phone' => 'required',
        ];
    }
}