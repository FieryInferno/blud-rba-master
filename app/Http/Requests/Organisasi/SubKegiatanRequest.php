<?php

namespace App\Http\Requests\Organisasi;

use Illuminate\Foundation\Http\FormRequest;

class SubKegiatanRequest extends FormRequest
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
        $id = $this->request->get('idSubKegiatan');
        return [
            'kodeKegiatan'      => 'required',
            'kodeSubKegiatan'   => 'required',
            'namaSubKegiatan'   => 'required|string'
        ];
    }
}
