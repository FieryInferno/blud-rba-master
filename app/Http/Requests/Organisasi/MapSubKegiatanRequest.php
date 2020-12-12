<?php

namespace App\Http\Requests\Organisasi;

use Illuminate\Foundation\Http\FormRequest;

class MapSubKegiatanRequest extends FormRequest
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
        $id = $this->request->get('idMapSubKegiatan');
        return [
            'kodeUnitKerja'     => 'required',
            'kodeSubKegiatanBlud' => 'required',
            'kodeSubKegiatanApbd' => 'required'
        ];
    }
}
