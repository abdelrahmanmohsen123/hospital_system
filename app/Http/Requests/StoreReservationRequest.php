<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // $time = Carbon::parse('time')->format('H');
        return [
            //
            'reserve_date' => 'required| after:yesterday',
            'reserve_time' => 'required',
            'speciality_id' => 'required|exists:specialities,id',
        ];
    }
}