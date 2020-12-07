<?php

namespace App\Http\Requests\SalinAnggaran;

use Illuminate\Foundation\Http\FormRequest;

class SalinAnggaranRbaRequest extends FormRequest
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
            'status_anggaran.*' => 'nullable',
            'rba_selected.*' => 'required'
        ];
    }
}
