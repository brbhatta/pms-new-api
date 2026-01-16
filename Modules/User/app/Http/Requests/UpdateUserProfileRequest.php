<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust if authorization is needed
    }

    public function rules(): array
    {
        return [
            'full_name' => 'nullable|string',
            'address' => 'nullable|array',
            'profile_picture' => 'nullable|string',
            'employee_identifier' => 'nullable|string',
        ];
    }
}
