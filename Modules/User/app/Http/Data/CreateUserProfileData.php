<?php

namespace Modules\User\Http\Data;

use Spatie\LaravelData\Data;

class CreateUserProfileData extends Data
{
    public function __construct(
        public string $fullName,
        public array $address,
        public ?string $profilePicture,
        public string $employeeIdentifier,
    ) {}

    public static function rules(): array
    {
        return [
            'fullName' => 'required|string',
            'address' => 'required|array',
            'profilePicture' => 'nullable|string',
            'employeeIdentifier' => 'required|string',
        ];
    }

    public static function messages(): array
    {
        return [
            'fullName.required' => 'Your Full name is required.',
            'fullName.string' => 'Full name must be a string.',
            'address.required' => 'Address is required.',
            'address.array' => 'Address must be an array.',
            'profilePicture.string' => 'Profile picture must be a string.',
            'employeeIdentifier.required' => 'Employee identifier is required.',
            'employeeIdentifier.string' => 'Employee identifier must be a string.',
        ];
    }
}
