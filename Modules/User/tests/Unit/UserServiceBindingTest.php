<?php

use Modules\User\Application\Contracts\UserServiceInterface;

uses(Modules\User\Tests\TestCase::class);

it('resolves the UserServiceInterface from the container', function () {
    $service = app()->make(UserServiceInterface::class);

    expect($service)->toBeInstanceOf(UserServiceInterface::class);
});
