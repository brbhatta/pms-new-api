<?php

use Illuminate\Support\Facades\Event;
use Modules\User\Application\UseCases\UpdateUserAction;
use Modules\User\Http\Data\UserData;
use Modules\User\Http\Events\UserProfileUpdated;
use Modules\User\Models\User;

uses(Modules\User\Tests\TestCase::class);

it('updates a user and dispatches UserProfileUpdated event', function () {
    Event::fake();

    $user = User::factory()->create(['name' => 'Old Name']);

    $data = UserData::from([
        'name' => 'New Name',
        'email' => $user->email,
        'password' => 'secret',
    ]);

    $result = resolve(UpdateUserAction::class)->handle($user->id, $data);

    expect($result)->toBeInstanceOf(UserData::class);
    expect($result->name)->toBe('New Name');

    Event::assertDispatched(UserProfileUpdated::class, function ($event) use ($user) {
        return $event->userId === $user->id && is_array($event->updatedFields);
    });
});
