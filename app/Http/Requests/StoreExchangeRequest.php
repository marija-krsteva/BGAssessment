<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExchangeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'item_exchanged_id'  => 'required|exists:items,id',
            'item_exchanged_into_id' => 'required|exists:items,id',
            'rate' => 'required|numeric|between:-10,99.99',
        ];
    }
}
