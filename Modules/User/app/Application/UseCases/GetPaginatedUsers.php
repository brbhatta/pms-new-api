<?php

namespace Modules\User\Application\UseCases;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Http\Data\UserData;
use Modules\User\Models\User;

final readonly class GetPaginatedUsers
{
    private int $perPage;

    public function __construct(
        private User $userModel
    ) {
        $this->perPage = config('pagination.default_per_page', 15);
    }

    public function handle(): LengthAwarePaginator
    {
        return $this->userModel
            ->newQuery()
            ->paginate($this->perPage)
            ->through(fn(User $user) => UserData::from($user));
    }
}
