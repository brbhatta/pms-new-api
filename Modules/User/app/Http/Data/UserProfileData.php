<?php

namespace Modules\User\Http\Data;

use Spatie\LaravelData\Data;

class UserProfileData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public ?string $fullName,
        public ?array $address,
        public ?string $profilePicture,
        public ?string $employeeIdentifier,
        public ?string $emailVerifiedAt,
        public string $createdAt,
        public string $updatedAt,
    ) {}
}
