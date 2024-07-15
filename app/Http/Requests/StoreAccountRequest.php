<?php

namespace App\Http\Requests;

use App\Models\Account;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('account_create');
    }

    public function rules()
    {
        return [
            'value' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'service_att' => [
                'required',
            ],
            'service_id' => [
                'required',
            ],
        ];
    }
}
