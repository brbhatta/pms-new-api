<?php

namespace Modules\Organisation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignUserToUnitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|string|uuid',
            'post_id' => 'required|string|uuid',
            'organisation_unit_id' => 'required|string|uuid',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }
}
