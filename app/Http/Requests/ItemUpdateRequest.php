<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends MasterRequest
{

    public function rules(): array
    {
        return [
            'user_id' => 'nullable',
            'item_id' => 'required|exists:items,id',
            'title' => 'nullable|min:8',
            'description' => 'nullable|min:8',
            'file' => 'nullable|mimes:pdf',
            'date' => 'nullable'
        ];
    }
}
