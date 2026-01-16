<?php

namespace Modules\User\Http\Data;

use Spatie\LaravelData\Data;

class UpdateUserProfileData extends Data
{
    public function __construct(
        public ?string $fullName,
        public ?array $address,
        public ?string $profilePicture,
        public ?string $employeeIdentifier,
    ) {}

    public static function rules(): array
    {
        return [
            'full_name' => 'nullable|string',
            'address' => 'nullable|array',
            'profile_picture' => 'nullable|string',
            'employee_identifier' => 'nullable|string',
        ];
    }
}
