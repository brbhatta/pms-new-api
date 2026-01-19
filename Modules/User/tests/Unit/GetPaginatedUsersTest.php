<?php

use Modules\User\Application\UseCases\GetPaginatedUsers;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

it('returns a LengthAwarePaginator with mapped UserData items', function () {
    // create 5 users
    User::factory()->count(5)->create();

    $useCase = new GetPaginatedUsers(new User());

    $paginator = $useCase->handle();

    expect($paginator)->toBeInstanceOf(Illuminate\Pagination\LengthAwarePaginator::class);
    expect($paginator->total())->toBeGreaterThanOrEqual(5);

    // The paginator should contain items mapped to arrays or objects from UserData
    $items = $paginator->items();
    expect(is_array($items))->toBeTrue();
    expect(count($items))->toBeGreaterThan(0);
});
