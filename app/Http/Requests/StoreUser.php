<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Livewire\Attributes\Rule;

class StoreUser extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
//        dd($this);
        return [
            'surname' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users','email')->ignore($this->user_id, 'id')
                ],
            'patron' => 'required',
            'phone' => 'required',
            'series_passport' => 'required',
            'number_passport' => 'required',
            'date_of_birth' => 'required',
            'snils' => 'nullable',
            'sex' => 'required',
            'nationality' => 'nullable',
        ];
    }
}
