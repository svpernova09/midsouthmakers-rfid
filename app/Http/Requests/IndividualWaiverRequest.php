<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndividualWaiverRequest extends FormRequest
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
            'between_name' => 'required',
            'initial_1' => 'required|same:initial_2|same:initial_3',
            'initial_2' => 'required|same:initial_1|same:initial_3',
            'initial_3' => 'required|same:initial_1|same:initial_2',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'signature' => 'required',
            'birth_date' => 'required|date_format:"YY/MM/DD"',
        ];
    }

    public function messages()
    {
        return [
            'initial_1.same' => 'The initials must match.',
            'initial_2.same' => 'The initials must match.',
            'initial_3.same' => 'The initials must match.',
            'birth_date.date_format' => 'Date of Birth does not match format "YY/MM/DD".',
        ];
    }
}
