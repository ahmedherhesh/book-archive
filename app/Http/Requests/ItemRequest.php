<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends MasterRequest
{

    public function rules(): array
    {
        return [
            'user_id' => 'nullable',
            'title' => 'required|min:8',
            'description' => 'required|min:8',
            'file' => 'required|mimes:pdf',
            'date' => 'required'
        ];
    }
}
