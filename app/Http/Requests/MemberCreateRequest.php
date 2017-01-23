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
        return (bool)Auth::user()->admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => 'required|numeric|unique:users,key',
            'pin' => 'required|numeric',
            'ircName' => 'required|string',
            'spokenName' => 'required|string',
            'isAdmin' => 'required|boolean',
            'isActive' => 'required|boolean',
        ];
    }
}