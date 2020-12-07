<?php

namespace App\Http\Requests\DataDasar;

use Illuminate\Foundation\Http\FormRequest;

class AkunRequest extends FormRequest
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
        $id = $this->request->get('id');
        return [
            'tipe' => 'required',
            'kelompok' => 'nullable',
            'jenis' => 'nullable',
            'objek' => 'nullable',
            'rincian' => 'nullable',
            'sub1' => 'nullable',
            'sub2' => 'nullable',
            'sub3' => 'nullable',
            'kode_akun' => 'required|unique:akun,kode_akun,'.$id,
            'nama_akun' => 'required',
            'kategori' => 'required',
            'pagu' => 'nullable',
        ];
    }
}
