<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:500',
            'brand_id' => 'nullable|integer',
            'invoice_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'call_log' => 'nullable|string|max:500',
            'lead_status' => 'required|string|max:150',
        ];
    }
}