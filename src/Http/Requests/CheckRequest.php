<?php

namespace Sandwave\PhonePinChecker\Http\Requests;

use Illuminate\Http\Request;

class CheckRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|numeric',
        ];
    }
}
