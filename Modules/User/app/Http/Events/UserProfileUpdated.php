<?php

namespace Modules\User\Http\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserProfileUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $userId,
        public array $updatedFields
    ) {}
}
