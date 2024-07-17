<?php

namespace App\Http\Requests;

use App\Models\Account;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('account_edit');
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
            'comment' => [
                'required',
            ],
        ];
    }
}
