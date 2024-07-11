<?php

namespace App\Http\Requests;

use App\Models\ServicesAttribute;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServicesAttributeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('services_attribute_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:services_attributes,id',
        ];
    }
}
