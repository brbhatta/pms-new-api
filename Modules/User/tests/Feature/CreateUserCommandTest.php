<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Modules\User\Application\Console\CreateUserCommand;
use Modules\User\Application\UseCases\CreateUserAction;
use Modules\User\Http\Data\UserData;
use Symfony\Component\Console\Output\BufferedOutput;

uses(Modules\User\Tests\TestCase::class);

it('calls the CreateUserAction and completes successfully', function () {
    $name = 'Amit Sharma';
    $email = 'amit@example.com';
    $password = 'secret123';

    $output = new BufferedOutput();

    $exit = Artisan::call('user:create', ['name' => $name, 'email' => $email, 'password' => $password], $output);

    expect($exit)->toBe(0);
});
