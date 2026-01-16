<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust if authorization is needed
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'address' => 'required|array',
            'profile_picture' => 'nullable|string',
            'employee_identifier' => 'required|string',
        ];
    }
}
