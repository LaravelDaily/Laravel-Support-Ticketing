<?php

namespace App\Http\Requests;

use App\Priority;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPriorityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:priorities,id',
        ];
    }
}
