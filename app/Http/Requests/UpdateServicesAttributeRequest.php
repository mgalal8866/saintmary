<?php

namespace App\Http\Requests;

use App\Models\ServicesAttribute;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServicesAttributeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('services_attribute_edit');
    }

    public function rules()
    {
        return [
            'service_id' => [
                'required',
                'integer',
            ],
            'value' => [
                'string',
                'required',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}
