<?php

namespace App\Http\Requests;

use App\Peminjaman;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePeminjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('peminjaman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'nama'  => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'barang_pinjam' => [
                'required',
            ],
            'tanggal_pinjam' => [
                'required',
            ],
            'tanggal_kembali' => [

            ]
        ];
    }
}
