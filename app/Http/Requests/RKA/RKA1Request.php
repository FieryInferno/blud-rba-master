<?php

namespace App\Http\Requests\RKA;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class RKA1Request extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'kode_opd' => 'required',
            'unit_kerja' => 'required',
            'pejabat_unit' => 'required',
            'kode_rekening.*' => 'required',
            'sumber_dana.*' => 'required',
        ];

         if ($request->volume_pak){
             $rules['tarif_pak'] = 'required';
             $rules['satuan_pak'] = 'required';
             $rules['volume_pak'] = 'required';
             $rules['nominal_pak'] = 'required';
         }else {
             $rules['tarif'] = 'required';
             $rules['satuan'] = 'required';
             $rules['volume'] = 'required';
         }
        
        return $rules;
    }
}
