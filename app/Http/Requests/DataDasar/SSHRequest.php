<?php

namespace App\Http\Requests\DataDasar;

use Illuminate\Foundation\Http\FormRequest;

class SSHRequest extends FormRequest
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
            'golongan' => 'required',
            'bidang' => 'nullable',
            'kelompok' => 'nullable',
            'sub1' => 'nullable',
            'sub2' => 'nullable',
            'sub3' => 'nullable',
            'sub4' => 'nullable',
            'kode_akun' => 'required',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'merk' => 'required',
            'spesifikasi' => 'required',
            'harga' => 'required',
        ];
    }
}
