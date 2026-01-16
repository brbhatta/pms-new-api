<?php

namespace Modules\User\Application\Queries;

use App\Framework\Query;

class GetUserProfileQuery implements Query
{
    public function __construct(
        public string $userId
    ) {}
}
