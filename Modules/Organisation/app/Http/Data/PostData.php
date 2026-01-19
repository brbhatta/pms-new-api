<?php

namespace Modules\Organisation\Http\Data;

use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class PostData extends Data
{
    public string|Optional $id;

    public string $name;

    public string $code;

    public int $level;

    #[MapInputName('reports_to_post_id')]
    public ?string $reportsToPostId;

    public ?array $metadata;
}
