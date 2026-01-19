<?php

namespace Modules\User\Http\Data;

use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserData extends Data
{
    public string|Optional $id;
    public string $name;

    #[Email]
    public string $email;

    #[Hidden]
    public string $password;

    public ?array $metadata;
}
