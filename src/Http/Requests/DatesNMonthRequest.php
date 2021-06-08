<?php

namespace Reddot\TegetaReservation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatesNMonthRequest extends FormRequest
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
            'branch' => 'required',
            'service_type' => 'required',
            'year' => 'required',
            'month' => 'required',
            'n' => 'required',
        ];
    }
}
