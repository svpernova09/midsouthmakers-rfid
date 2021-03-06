<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MemberCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) Auth::user()->admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => 'required|numeric|unique:members,key',
            'pin' => 'required|numeric',
            'irc_name' => 'required|string',
            'spoken_name' => 'required|string',
            'admin' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
