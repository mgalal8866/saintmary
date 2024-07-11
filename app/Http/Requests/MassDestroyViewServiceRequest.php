<?php

namespace App\Http\Requests;

use App\Models\ViewService;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyViewServiceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('view_service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:view_services,id',
        ];
    }
}
