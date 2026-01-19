<?php

namespace Modules\Organisation\Http\Data;

use Carbon\CarbonImmutable;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class PostingData extends Data
{
    public string|Optional $id;

    #[MapInputName('post_id')]
    public string $postId;

    public PostData $post;

    #[MapInputName('organisation_unit_id')]
    public string $organisationUnitId;

    public string $postingType;

    #[MapInputName('start_date')]
    public CarbonImmutable $startDate;

    #[MapInputName('end_date')]
    public ?CarbonImmutable $endDate;
}
