<?php

namespace App\Http\Requests;

use App\Models\ViewService;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateViewServiceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('view_service_edit');
    }

    public function rules()
    {
        return [
            'service_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
